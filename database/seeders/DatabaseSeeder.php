<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Users::class);
        $this->call(Categories::class);
        $this->call(Posts::class);
        $this->call(Comments::class);
        
        // \App\Models\User::factory(10)->create();
    }
}
