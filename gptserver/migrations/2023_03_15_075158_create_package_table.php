<?php

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreatePackageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('package', function (Blueprint $table) {
            $table->comment('套餐');
            $table->bigIncrements('id');
            $table->string('name')->comment('套餐名称');
            $table->string('show_name')->comment('展示名称');
            $table->tinyInteger('identity')->default(\App\Model\Package::IDENTITY_USER)->comment('身份');
            $table->string('code', 20)->nullable()->comment('标识，同标识的套餐会累加');
            $table->tinyInteger('type')->comment('类型, 对话，图片生成，等等');
            $table->tinyInteger('sort')->default(0)->comment('排序，越大越前');
            $table->unsignedSmallInteger('expired_day')->default(1)->comment('有效期，单位天，0表示不限制时间');
            $table->bigInteger('num')->comment('套餐内次数，如果为-1则表示不限制');
            $table->decimal('price', 9)->comment('售价');
            $table->tinyInteger('level')->default(0)->comment('扣费优先级，越大越优先');
            $table->unsignedTinyInteger('show')->default(1)->comment('是否展示');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package');
    }
}
