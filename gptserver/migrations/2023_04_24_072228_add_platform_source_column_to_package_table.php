<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AddPlatformSourceColumnToPackageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('package', function (Blueprint $table) {
            $table->tinyInteger('platform')->default(\App\Model\Package::PLATFORM_GPT)->comment('注册平台');
            $table->tinyInteger('business_id')->default(0)->comment('商户ID/模型ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package', function (Blueprint $table) {
            //
        });
    }
}
