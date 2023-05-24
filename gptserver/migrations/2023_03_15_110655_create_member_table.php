<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use App\Model\Member;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('member', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nickname')->nullable()->comment('用户名');
            $table->string('avatar')->nullable()->comment('用户头像');
            $table->string('mobile', 30)->nullable()->comment('手机号');
            $table->char('code', 16)->unique()->comment('用户标识码');
			$table->unsignedTinyInteger('status')->default(Member::STATUS_NORMAL)->comment('状态, 1正常，2禁用');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
}
