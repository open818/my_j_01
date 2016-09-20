<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //用户登录日志
        Schema::create('imp_company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->common('公司名称');
            $table->string('circle',100)->common('商圈');
            $table->integer('circle_id')->nullable()->common('商圈ID');
            $table->string('city1',50)->default('')->common('省');
            $table->string('city2',50)->default('')->common('市');
            $table->string('address',200)->default('')->common('详细地址');
            $table->string('profile',2000)->default('')->common('简介');
            $table->string('username',50)->default('')->common('联系人');
            $table->string('mobile',11)->default('')->common('手机');
            $table->string('position',20)->default('')->common('职务');
            $table->string('territory',20)->default('')->common('负责区域');
            $table->integer('user_id')->nullable()->common('用户ID');
            $table->integer('company_id')->nullable()->common('公司ID');
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
