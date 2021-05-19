<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Users::create([
            'login' => 'superadmin',
            'password' => Hash::make('superadmin'),
            'email' => 'admin@admin.com',
            'name' => 'Name Surname',
            'role' => 'admin'
        ]);
        \App\Models\Users::create([
            'login' => 'superuser',
            'password' => Hash::make('superuser'),
            'email' => 'user@admin.com',
            'name' => 'Name User',
            'role' => 'user'
        ]);
        \App\Models\Users::create([
            'login' => 'Kate',
            'password' => Hash::make('superadmin'),
            'email' => 'kateadmin@admin.com',
            'name' => 'Name Surname',
            'role' => 'admin'
        ]);
        \App\Models\Users::create([
            'login' => 'Nadia',
            'password' => Hash::make('superadmin'),
            'email' => 'Nadia@admin.com',
            'name' => 'Name Surname',
            'role' => 'admin'
        ]);
        \App\Models\Users::create([
            'login' => 'nice',
            'password' => Hash::make('superadmin'),
            'email' => 'nice@admin.com',
            'name' => 'Name Surname',
            'role' => 'admin'
        ]);
    }
}
