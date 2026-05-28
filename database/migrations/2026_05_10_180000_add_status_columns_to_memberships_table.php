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
        Schema::table('memberships', function (Blueprint $table) {
            // Approval workflow
            $table->string('approval_status')->default('Pending')->after('declaration_date');
            $table->string('membership_id')->nullable()->after('approval_status');
            $table->timestamp('approved_at')->nullable()->after('membership_id');

            // Payment tracking
            $table->string('payment_status')->nullable()->after('approved_at');
            $table->string('subscription_status')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn([
                'approval_status',
                'membership_id',
                'approved_at',
                'payment_status',
                'subscription_status',
            ]);
        });
    }
};
