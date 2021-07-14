<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryPostTable extends Migration
{
    public function up()
    {
        Schema::create('category_post', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id');
            $table->bigInteger('post_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_post');
    }
}
