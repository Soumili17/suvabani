<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->boolean('is_recent_project')->default(false)->after('video_url');
            $table->unsignedInteger('display_order')->default(0)->after('is_recent_project');
        });

        DB::table('galleries')
            ->where('type', 'image')
            ->whereNotNull('image')
            ->update(['is_recent_project' => true]);
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['is_recent_project', 'display_order']);
        });
    }
};
