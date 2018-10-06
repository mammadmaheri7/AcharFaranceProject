<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table)
        {
            $table->increments('id');

            $table->integer('scope_id')->unsigned()->nullable(true);
            $table->foreign('scope_id')->references('id')->on('scopes')->onDelete('cascade')->onUpdate('cascade');

            $table->string('name_english');
            $table->string('name_farsi');
            $table->string('body');

            $table->integer('user_id')->unsigned()->nullable(true);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('skills');
    }
}
