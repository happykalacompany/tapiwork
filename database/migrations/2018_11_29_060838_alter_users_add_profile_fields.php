<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersAddProfileFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('favorite_coffee')->after('avatar')->comment('最喜欢的咖啡');
            $table->text('flavor_note')->after('favorite_coffee')->comment('口味记录');
            $table->integer('profile_visibility')->default(1)->after('flavor_note')->comment('信息是否公开可见');
            $table->text('city')->after('profile_visibility')->comment('所在城市');
            $table->text('state')->after('city')->comment('所在省份');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('favorite_coffee');
            $table->dropColumn('flavor_note');
            $table->dropColumn('profile_visibility');
            $table->dropColumn('city');
            $table->dropColumn('state');
        });
    }
}
