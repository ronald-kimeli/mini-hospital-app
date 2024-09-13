<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('referrals', function (Blueprint $table) {
            $table->unsignedBigInteger(column: 'referral_department_id')->default(value: 2);
            $table->foreign('referral_department_id')->references('id')->on('departments')->onDelete(action: 'restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referrals', function (Blueprint $table) {
            $table->dropForeign(index: ['referral_department_id']);
            $table->dropColumn('referral_department_id');
        });
    }
};
