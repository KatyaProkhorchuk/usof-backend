<?php

namespace App\Http\Controllers;
use App\Models\Comments;
use Illuminate\Http\Request;
use App\Models\LikeAll;
use App\Models\Post;
class CommentsController extends Controller
{
    public function getById($id,Request $request){
        // return $id;
        $query = Comments::query();
        $result = $query->where('id', '=', $id)->get('*');
        return $result;
    }
    public function createNewLike($id,Request $request){
       
        $user_id = auth()->user()->id; 
        // return $user_id;
        $result  = LikeAll::where('comment_id', '=', $id)->where('user_id', '=', $user_id)->get()->all();
        
        if ($result)
            return ['error'=>'you are liked this post yet'];
        $data = $request->all();
        $data['user_id'] = $user_id;
        $data['comment_id'] = $id;
        $result = LikeAll::create($data);
        return $result;
    }
    public function gelAllLikes($id,Request $request){
        $user_id = auth()->user()->id;
        $result  = LikeAll::where('comment_id', '=', $id)->get()->all();
        return $result;
    }
    public function update($id,Request $request){
        $data = $request->all();
        $query = Comments::query()->where('id', '=', $id);
        $result = array();
        if (isset($data['content']))
            array_push($result, $query->update(['content' => $data['content']]));
        foreach ($result as $key)
            if ($key == 0)
                return ["ok" => false];
            return ["ok" => true];
    }
    public function delete($id,Request $request){
        // $role=auth()->user()->role;
        // if ($role=='user')
        //     return response()->json(['error' => 'Forbidden'], 403);
        $data = $request->all();
        $query = Comments::query()->where('id', '=', $id);
        $result=$query->delete();
        return $result;
    }
    public function deleteLike($id,Request $request){
        // $role=auth()->user()->role;
        // if ($role=='user')
        //     return response()->json(['error' => 'Forbidden'], 403);
        $data = $request->all();
        $query = LikeAll::query()->where('comment_id', '=', $id);
        $result=$query->delete();
        return $result;
    }
}
