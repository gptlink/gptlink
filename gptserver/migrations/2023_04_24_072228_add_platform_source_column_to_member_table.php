<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AddPlatformSourceColumnToMemberTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->tinyInteger('platform')->default(\App\Model\Member::PLATFORM_GPT)->comment('注册平台');
            $table->tinyInteger('business_id')->default(0)->comment('商户ID/模型ID');
            $table->string('source', 150)->nullable()->comment('注册来源平台');
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
