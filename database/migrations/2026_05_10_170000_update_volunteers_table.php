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
        Schema::table('volunteers', function (Blueprint $table) {
            // Drop email and phone columns
            $table->dropColumn(['email', 'phone']);

            // Rename id_card to profile_pic
            $table->renameColumn('id_card', 'profile_pic');

            // Add designation column
            $table->string('designation')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->renameColumn('profile_pic', 'id_card');
            $table->dropColumn('designation');
        });
    }
};
