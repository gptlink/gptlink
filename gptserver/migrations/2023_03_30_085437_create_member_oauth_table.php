<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateMemberOauthTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('member_oauth', function (Blueprint $table) {
            $table->comment('会员第三方表');
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id')->default(0)->comment('会员 id');
            $table->string('platform', 50)->comment('第三方平台');
            $table->string('appid')->nullable()->comment('公众号 appid');
            $table->string('openid')->nullable()->comment('用户的openid');
            $table->string('unionid')->nullable()->comment('平台的union_id');
            $table->string('nickname', 100)->nullable()->comment('用户名');
            $table->string('avatar')->nullable()->comment('用户头像');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_oauth');
    }
}
