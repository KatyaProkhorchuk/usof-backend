<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login', 10)->unique()->charset('utf8')->collation('utf8_general_ci');
            $table->string('password')->charset('utf8')->collation('utf8_general_ci');
            $table->string('name', 20)->charset('utf8')->collation('utf8_general_ci');
            $table->string('email', 64)->unique()->charset('utf8')->collation('utf8_general_ci');
            $table->string('profile_pictures')->default('avatars/default.jpeg');
            $table->json('faves')->nullable();
            $table->integer('rating')->default(0);
            $table->enum('role', ['user', 'admin'])->default('user')->charset('latin1')->collation('latin1_general_ci');

            $table->timestamps();
            // $table->id();
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            // $table->rememberToken();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
