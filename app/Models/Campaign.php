<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use SoftDeletes;

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    protected $fillable = [
        'category_id',
        'created_by',
        'title',
        'slug',
        'short_description',
        'description',
        'goal_amount', // stored in paise
        'start_date',
        'end_date',
        'status',
        'cover_media_path',
        'display_order',
        'published_at',
        'beneficiary_name',
        'location',
        'story',
        'why_funding',
        'fund_utilization',
        'milestones',
        'video_url',
        'minimum_donation_amount',
        'is_featured',
        'visibility',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(CampaignCategory::class);
    }

    public function media()
    {
        return $this->hasMany(CampaignMedia::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function updates()
    {
        return $this->hasMany(CampaignUpdate::class);
    }

    /**
     * Calculate total amount raised (in paise) from successful donations.
     */
    public function totalDonations(): int
    {
        return $this->donations()
            ->whereIn('payment_status', ['Paid', 'paid'])
            ->sum('amount') * 100;
    }

    public function donorCount(): int
    {
        return $this->donations()
            ->whereIn('payment_status', ['Paid', 'paid'])
            ->count();
    }

    /**
     * Percentage of goal achieved.
     */
    public function progressPercentage(): float
    {
        if ($this->goal_amount == 0) return 0;
        return min(100, ($this->totalDonations() / $this->goal_amount) * 100);
    }
}
?>
