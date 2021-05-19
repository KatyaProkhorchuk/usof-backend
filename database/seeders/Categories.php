<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Categories::create([
            'title' => 'python',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
          ]);
          \App\Models\Categories::create([
            'title' => 'web',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
          ]);
          \App\Models\Categories::create([
            'title' => 'php',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
          ]);
          \App\Models\Categories::create([
            'title' => 'laravel',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
          ]);
          \App\Models\Categories::create([
            'title' => 'backend',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
          ]);
    
    }
}
