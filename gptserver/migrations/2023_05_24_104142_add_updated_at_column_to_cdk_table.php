<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AddUpdatedAtColumnToCdkTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cdk', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->default(0)->after('user_id')->comment('兑换码批次号');
            $table->timestamp('updated_at')->nullable()->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cdk', function (Blueprint $table) {
        });
    }
}
