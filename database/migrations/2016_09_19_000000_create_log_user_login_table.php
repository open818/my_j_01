<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogUserLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //用户登录日志
        Schema::create('log_user_login', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->common('登录用户ID');
            $table->string('login_mobile',20)->common('登录账号');
            $table->string('login_ip')->default('')->common('IP地址');
            $table->string('source')->default('')->common('来源');
            $table->string('user_agent')->default('');
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
        Schema::drop('log_user_login');
    }
}
