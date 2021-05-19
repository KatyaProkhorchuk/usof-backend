<?php

namespace App\Http\Controllers;
use App\Models\Categories;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Models\Post;
class CategoriesController extends Controller
{
    //
    public function getAll()
    {
        $role=auth()->user()->role;
        if ($role=='user')
            return response()->json(['error' => 'Forbidden'], 403);
        $query = Categories::query();
        $result = $query->get('*');
        return $result;
    }
    public function createCategories(Request $request)
    {
        $role=auth()->user()->role;
        // return $role;
        if ($role=='user')
            return response()->json(['error' => 'you are haven\'t admin root'], 403);
        $query = Categories::query();
        $result = $query->create($request->all());
        return $result;
    }
    public function update($id,Request $request){
        $role=auth()->user()->role;
        if ($role=='user')
            return response()->json(['error' => 'you are haven\'t admin root'], 403);
        $data = $request->all();
        $query = Categories::query()->where('id', '=', $id);
        $result = array();
        if (isset($data['title']))
            array_push($result, $query->update(['title' => $data['title']]));
        if (isset($data['description']))
            array_push($result, $query->update(['description' => $data['description']]));
            foreach ($result as $key)
            if ($key == 0)
                return ["ok" => false];
    return ["ok" => true];
    }
    public function delete($id,Request $request){
        $role=auth()->user()->role;
        if ($role=='user')
            return response()->json(['error' => 'you are haven\'t admin root'], 403);
        $data = $request->all();
        $query = Categories::query()->where('id', '=', $id);
        $result=$query->delete();
        return $result;
    }
    public function getCategoriesById($id,Request $request){
        // return $id;
        $role=auth()->user()->role;
        if ($role=='user')
            return response()->json(['error' => 'you are haven\'t admin root'], 403);
        $query = Categories::query();
        $result = $query->where('id', '=', $id)->get('*');
        return $result;
    }
    public function getPosts($id){
        $role=auth()->user()->role;
        if ($role=='user')
            return response()->json(['error' => 'you are haven\'t admin root'], 403);
        $query = Categories::query()->where('id', '=', $id)->get('title')[0]['title'];
        $result= Post::query()->where('categories', '=', $query)->get('*')->all();
        if (!$result){
            return(['error'=>'don\'t have posts in this category']);
        }
        return $result;
    }
}
