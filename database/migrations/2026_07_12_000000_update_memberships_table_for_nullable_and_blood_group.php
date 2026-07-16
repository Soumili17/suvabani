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
            $table->string('nationality')->nullable()->change();
            $table->string('occupation')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->string('idproof')->nullable()->change();
            $table->string('idnumber')->nullable()->change();
            $table->string('blood_group')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->string('nationality')->nullable(false)->change();
            $table->string('occupation')->nullable(false)->change();
            $table->text('address')->nullable(false)->change();
            $table->string('idproof')->nullable(false)->change();
            $table->string('idnumber')->nullable(false)->change();
            $table->dropColumn('blood_group');
        });
    }
};
