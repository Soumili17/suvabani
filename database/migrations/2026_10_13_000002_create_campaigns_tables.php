<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('campaign_categories')) {
            Schema::create('campaign_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('campaigns')) {
            Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('campaign_categories')->nullOnDelete();
            $table->foreignId('created_by')->constrained('admins')->onDelete('cascade'); // assuming admins table
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('goal_amount'); // stored in paise
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->enum('status', ['draft','published','paused','completed','cancelled'])->default('draft');
            $table->string('cover_media_path')->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
        if (!Schema::hasTable('campaign_media')) {
            Schema::create('campaign_media', function (Blueprint $table) {
                $table->id();
                $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
                $table->enum('media_type', ['image','video']);
                $table->string('file_path');
                $table->string('thumbnail_path')->nullable();
                $table->string('alt_text')->nullable();
                $table->string('caption')->nullable();
                $table->integer('display_order')->default(0);
                $table->timestamps();
            });
        }

        // Add campaign_id to existing donations table for linking if not exists
        if (!Schema::hasColumn('donations', 'campaign_id')) {
            Schema::table('donations', function (Blueprint $table) {
                $table->foreignId('campaign_id')->nullable()->constrained('campaigns')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);
            $table->dropColumn('campaign_id');
        });
        Schema::dropIfExists('campaign_media');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('campaign_categories');
    }
};
?>
