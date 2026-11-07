<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('campaign_media') && ! Schema::hasColumn('campaign_media', 'deleted_at')) {
            Schema::table('campaign_media', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('campaign_media') && Schema::hasColumn('campaign_media', 'deleted_at')) {
            Schema::table('campaign_media', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
