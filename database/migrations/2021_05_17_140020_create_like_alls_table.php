<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikeAllsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_alls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id',);
            $table->unsignedBigInteger('post_id',)->nullable()->default(NULL);
            $table->unsignedBigInteger('comment_id',)->nullable()->default(NULL);
            $table->enum('type',['like','dislike']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->default(NULL);
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade')->default(NULL);
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like_alls');
    }
}
