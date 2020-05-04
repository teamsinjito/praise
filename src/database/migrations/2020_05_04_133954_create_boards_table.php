<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('from_user_id')->nullable();
            $table->unsignedinteger('to_user_id')->nullable();
            $table->unsignedinteger('stamp_id')->nullable();
            $table->string('message',30)->nullable();
            $table->integer('del_flg')->default(0);
            $table->timestamps();
            $table->rememberToken();  
        });

        Schema::table('boards', function ($table) {
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('to_user_id')-> references('id')->on('users')->onDelete('set null');
            $table->foreign('stamp_id')-> references('id')->on('stamps')->onDelete('set null');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
