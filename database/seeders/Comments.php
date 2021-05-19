<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Comments extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Comments::create([
            'user_id' => 29,
            'post_id' => 2,
            'content' => 'First testing comment',
        ]);
        \App\Models\Comments::create([
            'user_id' => 29,
            'post_id' => 2,
            'content' => 'Second testing comment',
        ]);\App\Models\Comments::create([
            'user_id' => 29,
            'post_id' => 2,
            'content' => 'Third testing comment',
        ]);\App\Models\Comments::create([
            'user_id' => 29,
            'post_id' => 2,
            'content' => 'Four testing comment',
        ]);\App\Models\Comments::create([
            'user_id' => 29,
            'post_id' => 2,
            'content' => 'Five testing comment',
        ]);
    }
}
