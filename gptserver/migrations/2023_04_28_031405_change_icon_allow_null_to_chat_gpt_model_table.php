<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class ChangeIconAllowNullToChatGptModelTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chat_gpt_model', function (Blueprint $table) {
            $table->string('icon', 255)->nullable()->comment('模型图标')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_gpt_model', function (Blueprint $table) {
            $table->string('icon', 255)->comment('模型图标')->change();
        });
    }
}
