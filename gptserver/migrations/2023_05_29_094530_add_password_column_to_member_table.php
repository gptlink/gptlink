<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AddPasswordColumnToMemberTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->string('password')->nullable()->comment('登陆密码');
            $table->tinyInteger('account_type')->default(\App\Model\Member::ACCOUNT_MOBILE)->comment('账号类型');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member', function (Blueprint $table) {
            //
        });
    }
}
