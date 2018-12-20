<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', '50')->comment('功能名称');
            $table->string('redirect', '50')->comment('跳转地址');
            $table->unsignedInteger('pid')->comment('父级');
            $table->unsignedInteger('sort')->comment('排序')->default(0);
            $table->unsignedTinyInteger('type')->comment('类型:0菜单,1非菜单')->default(0);
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
        Schema::dropIfExists('permissions');
    }
}
