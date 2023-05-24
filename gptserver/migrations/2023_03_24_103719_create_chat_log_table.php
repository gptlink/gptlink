<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateChatLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_log', function (Blueprint $table) {
            $table->string('id', 50)->primary()->comment('chat_id');
            $table->unsignedBigInteger('user_id')->default(0)->comment('用户id');
            $table->string('first_id', 50)->nullable()->comment('首记录id');
            $table->string('parent_id', 50)->nullable()->comment('父级id');
            $table->text('system')->nullable()->comment('咒语');
            $table->mediumText('ask')->nullable()->comment('问题');
            $table->mediumText('answer')->nullable()->comment('回答');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_log');
    }
}
