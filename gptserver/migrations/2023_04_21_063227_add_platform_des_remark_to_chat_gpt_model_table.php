<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AddPlatformDesRemarkToChatGptModelTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chat_gpt_model', function (Blueprint $table) {
            $table->text('prompt')->nullable()->change();
            $table->unsignedInteger('sort')->change();
            $table->unsignedTinyInteger('platform')->after('sort')->default(1)->comment('1.gpt;2.魔法书');
            $table->unsignedTinyInteger('source')->after('sort')->default(1)->comment('1.平台;2.魔法书');
            $table->unsignedTinyInteger('type')->after('sort')->default(1)->comment('1.对话;2.问答');
            $table->string('desc')->after('sort')->nullable()->comment('模型描述');
            $table->string('remark')->after('sort')->nullable()->comment('备注');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_gpt_model', function (Blueprint $table) {
            //
        });
    }
}
