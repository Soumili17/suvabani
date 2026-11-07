<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignMedia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'campaign_id',
        'media_type', // 'image' or 'video'
        'file_path',
        'thumbnail_path',
        'alt_text',
        'caption',
        'display_order',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
?>
