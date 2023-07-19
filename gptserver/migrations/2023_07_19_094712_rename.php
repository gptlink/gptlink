<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class Rename extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('chat_gpt_model', 'prompt');
        Schema::rename('chat_gpt_model_count', 'prompt_count');
        Schema::table('prompt_count', function (Blueprint $table) {
            $table->renameColumn('chat_gpt_model_id', 'prompt_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('', function (Blueprint $table) {
            //
        });
    }
}
