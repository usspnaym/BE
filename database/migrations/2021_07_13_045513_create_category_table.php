<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('categorys', function (Blueprint $table) {
            $table->id();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('categorys');
    }
}