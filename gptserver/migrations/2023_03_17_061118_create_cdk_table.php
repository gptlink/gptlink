<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCdkTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cdk', function (Blueprint $table) {
            $table->comment('兑换码');
            $table->bigIncrements('id');
            $table->integer('package_id')->comment('套餐ID');
            $table->string('code', 20)->unique()->comment('兑换码');
            $table->bigInteger('user_id')->default(0)->comment('使用的用户');
            $table->tinyInteger('status')->default(\App\Model\Cdk::STATUS_INIT)->comment('状态');
            $table->timestamp('expired_at')->nullable()->comment('过期时间');
            $table->timestamp('created_at')->useCurrent()->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cdk');
    }
}
