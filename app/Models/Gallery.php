<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'image',
        'type',
        'video_url',
        'is_recent_project',
        'display_order',
    ];

    protected $casts = [
        'is_recent_project' => 'boolean',
        'display_order' => 'integer',
    ];
}