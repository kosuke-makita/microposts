<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoriteTable extends Migration
{
   
    public function up()
   {
        Schema::create('favorite', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('micropost_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->timestamps();

            // Foreign key setting
//$table->foreign('micropost_id')->references('id')->on('microposts')->onDelete('cascade');
           // $table->foreign('user_id')->references('id')->on('microposts')->onDelete('cascade');

            // Do not allow duplication of combination of user_id and follow_id
           // $table->unique(['user_id', 'micropost_id']);
        });
    }

    public function down()
    {
        Schema::create('favorite', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('micropost_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->timestamps();
        });
    
    }
}



