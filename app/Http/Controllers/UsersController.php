<?php

namespace App\Http\Controllers;

// use App\Mail\ResetPasswordMail;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Contracts\Mail\Mailable;
// use App\Models\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
// use App\Http\Requests\RegisterRequest;
// use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\PasswordReset;
use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Support\Carbon;
// use Illuminate\Support\Facades\DB;
use App\Mail\ResetPasswordMail;
class UsersController extends Controller
{
    public function index(){
        $query = Users::query();
        $result = $query->get('*');
        return $result;
        // return Users::all();
    }
    public function register(Request $request){
        $request->validate([
            'login' => 'required',
            'password'=>'required',
            'name'=>'required',
            'email'=>'required',
            'profile_picture'=>'required',
            'rating'=>'required',
            'role'=>'required'
        ]);
        $query = Users::query();
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $result = $query->create($data);
        return $result;
    }
    public function getid($id){
        $query = Users::query();
        $result = $query->where('id', '=', $id)->get('*');
        return $result;
    }
    public function avatar(Request $request){
        $user_id = auth()->user()->id;
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('storage/images'), $imageName);
        $query = Users::query()->where('id', '=', $user_id);
        $result = $query->update(['picture' => $imageName]);
        return $result;
    }
    public function update(Request $request,$id){
        $user =Users::find($id);
        $user->update($request->all());
        return $user;
    }
    public function delete($id){
       return  Users::destroy($id);

    }
    // search 
    public function search($login){
        return  Users::where('login','like','%'.$login.'%')->get();
 
     }
     public function RegistersNewUser(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $result = Users::create($data);
        return $result;
        
    }
     public function login(Request $request)
    {
        // return $request;
        try {
            $credentials = $request->only(['email', 'password']);
            if (JWTAuth::attempt($credentials, ['exp' => \Carbon\Carbon::now()->addDays(7)->timestamp])) {
                $token = JWTAuth::attempt($credentials);
                $user = JWTAuth::user();
                return response([
                    'message' => 'Logged in',
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'expires_in' => JWTAuth::factory()->getTTL() * 60,
                    'user' => $user
                ]);
            } else
                return response([
                    'error' => 'Incorrect password!'
                ], 400);
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'error' => $e->getMessage()
            ], 401);
        }
    }
    public function logout(){
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response(['message' => 'Successfully logged out']);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return "Error";
        }
    }
    public function validateEmail($email)
    {
        return !!Users::where('email', $email)->first();
    }

    public function failedResponse()
    {
        return response()->json([
            'error' => 'Email does\'t found on our database'
        ], Response::HTTP_NOT_FOUND);
    }
    public function successResponse()
    { 
        return response()->json([
            'data' => 'Reset Email is send successfully, please check your inbox.'
        ], Response::HTTP_OK);
    }
    public function resetpassword(Request $request){
        if(!$this->validateEmail($request->email)){
            return $this->failedResponse();
        }
        else{
            $token = substr(bin2hex(random_bytes(10)), 0, 10);
            $email = $request->all()['email'];
            $result = Users::query()->where(['email' => $email])->get()->all();
            if (!$result)
                return 0;
            $login = Users::query()->where(['email' => $email])->get('login');
            $query = PasswordReset::query();
             return $this->send($email,$login,$token);
        }
    }
    public function send($email,$login,$token){ 
        
        $obj = new \stdClass();
        $obj->login = $login;
        $obj->link = 'http://127.0.0.1:8000/api/auth/password-reset/'.$token;;
        Mail::to($email)->send(new ResetPasswordMail($obj));
        return $this->successResponse();
    }
    public function resetpasswordwithtoken(Request $request,$token){
        // return $token;
        $query = Users::query()->where(['email' => $request->email]);
        $result = $query->get()->all();
        if (!$result)
            return $this->failedResponse();
        $email = $result[0]['email'];return $result;
        $password = Hash::make($request->all()["password"]);
        return $password;
        $result = Users::query()->where(['email' => $email])->update(["password" => $password]);
        return $result;    
    }
}
