<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AddIdentityColumnToMemberTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->tinyInteger('identity')->default(\App\Model\Member::IDENTITY_MEMBER)->comment('身份');
            $table->tinyInteger('ratio')->default(-1)->comment('佣金比例，大于等于0则使用单独配置');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member', function (Blueprint $table) {
            //
        });
    }
}
