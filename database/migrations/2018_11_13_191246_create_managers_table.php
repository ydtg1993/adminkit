<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account', 30)->comment('账号')->unique();
            $table->string('password', 200)->comment('密码');
            $table->unsignedTinyInteger('role_id')->default(0)->comment('角色ID');
            $table->timestamp('last_login_time')->comment('最后一次登录时间')->nullable();
            $table->unsignedInteger('last_login_ip')->comment('最后一次登录ip地址')->nullable();
            $table->string('contact', '20')->comment('联系人')->nullable();
            $table->char('contact_mobile', 22)->comment('联系人手机')->nullable();
            $table->unsignedInteger('frequency')->default(0)->comment('登录次数');
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
        Schema::dropIfExists('managers');
    }
}
