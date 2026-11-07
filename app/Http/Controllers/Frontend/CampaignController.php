<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of published campaigns.
     */
    public function index()
    {
        $campaigns = Campaign::with('category')
            ->where('status', 'published')
            ->where('visibility', 'public')
            ->orderBy('display_order')
            ->paginate(12);

        return view('frontend.campaigns.index', compact('campaigns'));
    }

    /**
     * Display the specified campaign by slug.
     */
    public function show($slug)
    {
        $campaign = Campaign::with([
                'category',
                'media' => fn ($query) => $query->orderBy('display_order'),
                'updates' => fn ($query) => $query->whereNotNull('published_at')->latest('published_at'),
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where('visibility', 'public')
            ->firstOrFail();

        return view('frontend.campaigns.show', compact('campaign'));
    }
}
?>
