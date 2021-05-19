<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Users;
use App\Models\Post;
use Illuminate\Http\Request;
use App\QueryFilters\PostsFilter;
use App\Models\LikeAll;
class PostController extends Controller
{
    public function getAll(Request $request){
        
        if (!$request->sort){
            $query = Post::query();
            $result = $query->orderBy('rating','DESC')->get('*');
            return $result;
        }
        else {
            // return $request;
            if($request->sort=='data'){
                $query = Post::query();
                $result = $query->orderBy('publishdate','DESC')->get('*');
                return $result;
            }
            if($request->sort=='publishdate'){
                $query = Post::query();
                $result = $query->orderBy('publishdate','DESC')->get('*');
                return $result;
            }
            if($request->sort=='interval'){
                $query = Post::query();
                $result = $query->orderBy('publishdate','DESC')->get('*');
                return $result;
            }
            if($request->sort=='publishdate'){
                $query = Post::query();
                $result = $query->orderBy('publishdate','DESC')->get('*');
                return $result;
            }
            if($request->sort=='status'){
                $query = Post::query();
                $result=$query->where('status', '=', TRUE)->orderBy('status','DESC')->get('*')->all();
                return $result;
            }
        }
    }
    public function getById($id){
        $query = Post::query();
        $result = $query->where('id', '=', $id)->get('*');
        return $result;
    }
    public function updatePost(Request $request,$id){

        $query = Post::query();
        try{
            $result = $query->where('id', '=', $id)->get('*');  
            $autor_id=$result[0]['user_id'];
            $data = $request->all();

        $user_id=auth()->user()->id;
        $role=auth()->user()->role;
        if($user_id==$autor_id){
            if ($autor_id!= $user_id && $role=='user')
            return response()->json(['error' => 'Forbidden'], 403);
            $result = array();
            if (isset($data['status'])){
                array_push($result, $query->update(['status' => $data['status']]));
            }
            if (isset($data['title'])){
                array_push($result, $query->update(['title' => $data['title']]));
            }
            if (isset($data['content'])){
                array_push($result, $query->update(['content' => $data['content']]));
            }
            if (isset($data['categories'])){
                array_push($result, $query->update(['categories' => json_encode($data['categories'])]));
            }
            foreach ($result as $key)
                if ($key == 0)
                    return ["ok" => false];
        return ["ok" => true];
        }
        else{
            return(['error'=>'it\'s no your post']);
        }
        }catch (\Exception $e) {return(['error'=>'not found']);}
       
        
        

    }
    public function createComments($id,Request $request){
        $user_id=auth()->user()->id;
        $status_post=Post::query()->where('id','=',$id)->where('status','=',TRUE)->get()->all();
        if(!$status_post){
            return (["error"=>'It\'s post doesn\'t active']);
        }
        $query=Comments::query();
        $data=$request->all();
        $data['post_id']=$id;
        $data['user_id']=$user_id;
        $data['content']=$request['content'];
        $result = $query->create($data);
        return $result;
    }
    public function getByIdComments($id){
        $query=Comments::query()->where('post_id','=',$id)->get('*');
        return $query;
    }
    public function deletePost($id){
        $query = Post::query();
        try{
            $result = $query->where('id', '=', $id)->get('*');  
            $autor_id=$result[0]['user_id'];
        $user_id=auth()->user()->id;
        $role=auth()->user()->role;
        if($user_id==$autor_id){
            $result=$query->delete();
        return $result;
        }
        else{
            return(['error'=>'it\'s no your post']);
        }
        }catch (\Exception $e) {return(['error'=>'not found']);}
    }
    public function createNewLike($id,Request $request){
        
        $user_id=auth()->user()->id;
        // return $user_id;
        $data=$request->all();
        $data['user_id']=$user_id;
        $data['post_id']=$id;
        $check=LikeAll::query()->where('post_id','=',$id)->where('user_id','=',$user_id)->get('*')->all();
        // return $check;

        if(!$check){
        $result=LikeAll::query()->create($data);
        if($data['type']=='like'){
            $query=Post::query()->where('id','=',$id)->increment('rating');//rating post ++
        }
        else{
            $query=Post::query()->where('id','=',$id)->derement('rating');//rating post --
        }
        return $result;
        }
        else{
            return (['error'=>'you are liked this post yet']);
        }
    }
    public function createNewPost(Request $request){
        
        $user_id = auth()->user()->id;
        $query = Post::query();
        $result= $request->all();
        $result['user_id'] = $user_id;
        if (isset($data['categories']))
            $result['categories'] = json_encode($result['categories']);
        $result = $query->create($result);
        return $result;
    }
    public function getAllLikes($id){
        $query = LikeAll::query();
        $status_post=Post::query()->where('id','=',$id)->where('status','=',TRUE)->get()->all();
        if($status_post){
        $result = $query->where('post_id', '=', $id)->get('*');
        return $result;
        }
        else return(['error'=>'this post inactive']);
    }
    public function deleteLikesUnderPost($id){
        $user_id=auth()->user()->id;
        $query=LikeAll::query()->where('post_id','=',$id)->where('user_id','=',$user_id
    );
        $result=$query->get(['user_id'])->all();
        // return $user_id;
        if(!$result){
            return (['error'=>'not found like under this post']);
        }
        if($result[0]['user_id']==$user_id){
            $result=$query->delete();
            $query=Post::query()->where('id','=',$id)->decrement('rating');
            return $result;
        }
        else{
            return (['error'=>'not found like your under this post']);

        }
    }
    public function getAllCategoriesPost($id)
    {   
        $query = Post::query();
        
        $result = $query->where('id', '=', $id);
        $result=$result->get('categories');
        return $result[0]['categories'];

    }
}
