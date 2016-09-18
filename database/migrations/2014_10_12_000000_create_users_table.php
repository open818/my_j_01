<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //搜索关键字
        Schema::create('keywords', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->common('日期');
            $table->string('keyword', 90)->common('关键字');
            $table->integer('count')->common('次数');
        });

        //update_files
        Schema::create('update_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->common('原文件名');
            $table->string('path',200)->common('存储路径');
            $table->string('ext', 10)->common('扩展名');
            $table->integer('user_id')->common('上传用户');
            $table->timestamps();
        });

        //个人用户
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20)->common('真实名称');
            $table->string('QQ', 11)->default('')->common('QQ号');
            $table->string('email', 30)->nullable()->common('邮箱');
            $table->string('mobile', 11)->unique()->common('手机');
            $table->string('phone', 20)->nullable()->common('电话');
            $table->string('friends', 2000)->nullable()->common('好友');
            $table->string('companies', 2000)->nullable()->common('关注的企业');
            $table->string('password', 100);
            $table->rememberToken();
            $table->timestamps();
        });

        //商圈
        Schema::create('business_circle', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->common('商圈名称');
            $table->string('address',200)->nullable()->common('地址编码');
            $table->string('address_details', 100)->nullable()->common('地址详情');
        });

        //品牌
        Schema::create('brand', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->common('品牌名称');
            $table->string('logo')->nullable()->common('品牌图片');
            $table->timestamps();
        });

        //分类
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->common('分类名称');
            $table->integer('seqno')->default(255)->common('排序号，最小排最前面');
            $table->char('status', 1)->default(1)->common('状态, 0: 作废 1: 有效');
            $table->timestamps();
        });

        //公司企业
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200)->common('公司名称');
            $table->string('profile', 2000)->nullable()->common('公司简介');
            $table->integer('business_circle_id')->nullable()->common('所属商圈');
            $table->string('business_address',200)->nullable()->common('经营地址');
            $table->string('address_details', 200)->nullable()->common('地址详情');
            $table->string('gsxt_url', 200)->nullable()->common('工商网站URL');
            $table->integer('sort_score')->default(0)->common('排序得分');
            $table->char('status', 1)->default(1)->common('状态，0：作废 1：有效 2：申请中');
            $table->timestamps();
        });

        //企业员工
        Schema::create('company_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->common('公司ID');
            $table->integer('user_id')->common('用户ID');
            $table->string('position', 30)->common('职位');
            $table->string('territory', 30)->common('负责区域');
            $table->char('isadmin', 1)->common('是否管理员，Y/N');
            $table->char('status', 1)->common('状态，0：作废 1：有效 2：申请中');
            $table->timestamps();
        });

        //企业动态
        Schema::create('company_dynamic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->common('公司ID');
            $table->integer('category_id')->nullable()->common('所属类目');
            $table->text('content')->common('内容');
            $table->text('attachments')->nullable()->common('附件');
            $table->integer('user_id')->common('创建人/联系人');
            $table->string('user_name',20)->common('创建人/联系人');
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

        Schema::drop('keywords');
        Schema::drop('update_files');
        Schema::drop('user');
        Schema::drop('business_circle');
        Schema::drop('brand');
        Schema::drop('category');
        Schema::drop('company');
        Schema::drop('company_user');
        Schema::drop('company_dynamic');
    }
}
