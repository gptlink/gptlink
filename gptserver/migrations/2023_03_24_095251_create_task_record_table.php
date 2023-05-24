<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTaskRecordTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_record', function (Blueprint $table) {
            $table->comment('任务记录');
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('用户 id');
            $table->unsignedBigInteger('task_id')->index()->comment('任务 id');
            $table->string('type', 50)->index()->comment('任务类型');
            $table->string('package_name')->comment('套餐副本名称');
            $table->string('expired_day')->comment('天数');
            $table->bigInteger('num')->comment('套餐内次数，如果为-1则表示不限制');
            $table->unsignedTinyInteger('is_read')->default(2)->comment('是否已读:1:已读;2:未读');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_record');
    }
}
