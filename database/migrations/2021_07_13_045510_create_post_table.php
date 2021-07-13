<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->longText('content');
            $table->bigInteger('category_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
