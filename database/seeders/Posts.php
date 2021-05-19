<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Posts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Post::create([
            'user_id' => '29',
            'title' => 'My first post',
            'status' => '1',
            'content' => 'First',
            'categories' => 'question',
            'rating'=>'0'
        ]);
        \App\Models\Post::create([
            'user_id' => '29',
            'title' => 'My second post',
            'status' => '1',
            'content' => 'Second',
            'categories' => 'question',
            'rating'=>'1'
        ]);
        \App\Models\Post::create([
            'user_id' => '29',
            'title' => 'My third post',
            'status' => '1',
            'content' => 'third',
            'categories' => 'question',
            'rating'=>'0'
        ]);
        \App\Models\Post::create([
            'user_id' => '29',
            'title' => 'My fourth post',
            'status' => '1',
            'content' => 'fourth',
            'categories' => 'question',
            'rating'=>'1'
        ]);
        \App\Models\Post::create([
            'user_id' => '29',
            'title' => 'My five post',
            'status' => '1',
            'content' => 'five',
            'categories' => 'question',
            'rating'=>'1'
        ]);
    }
}
