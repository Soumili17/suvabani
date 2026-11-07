<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('donations') && ! Schema::hasColumn('donations', 'anonymous')) {
            Schema::table('donations', function (Blueprint $table) {
                $table->boolean('anonymous')->default(false)->after('donor_name');
            });
        }

        if (Schema::hasTable('donations')) {
            Schema::table('donations', function (Blueprint $table) {
                $table->unique('razorpay_payment_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('donations')) {
            Schema::table('donations', function (Blueprint $table) {
                $table->dropUnique(['razorpay_payment_id']);
                if (Schema::hasColumn('donations', 'anonymous')) {
                    $table->dropColumn('anonymous');
                }
            });
        }
    }
};
