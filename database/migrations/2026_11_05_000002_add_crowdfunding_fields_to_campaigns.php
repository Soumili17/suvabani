<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('beneficiary_name')->nullable();
            $table->string('location')->nullable();
            $table->text('story')->nullable();
            $table->text('why_funding')->nullable();
            $table->text('fund_utilization')->nullable();
            $table->text('milestones')->nullable();
            $table->string('video_url')->nullable();
            $table->bigInteger('minimum_donation_amount')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('visibility')->default('public');
        });

        Schema::create('campaign_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_updates');

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn([
                'beneficiary_name', 'location', 'story', 'why_funding',
                'fund_utilization', 'milestones', 'video_url',
                'minimum_donation_amount', 'is_featured', 'visibility',
            ]);
        });
    }
};
