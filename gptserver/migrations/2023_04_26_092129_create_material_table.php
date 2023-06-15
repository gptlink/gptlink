<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateMaterialTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('material', function (Blueprint $table) {
            $table->comment('素材表');
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('type')->comment('类型');
            $table->string('title')->default('')->comment('文件名称');
            $table->string('file_url')->comment('文件路径');
            $table->unsignedBigInteger('size')->comment('大小 bytes');
            $table->string('format', 10)->comment('格式，后缀');
            $table->unsignedInteger('width')->comment('宽 px');
            $table->unsignedInteger('height')->comment('长 px');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material');
    }
}
