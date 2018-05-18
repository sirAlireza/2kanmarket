<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersInformations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_informations', function (Blueprint $table) {
            $table->charset = 'utf8';

            $table->increments('id');
            $table->char('name', 100);
            $table->char('lastname', 100);
            $table->date('birthday');
            $table->string('phone');
            $table->string('person_id');
            $table->string('moaref_id');
            $table->bigInteger('user_id');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_informations');
    }
}
