<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Campaign;
use App\Models\HeroBanner;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class FrontendController extends Controller
{
    public function index()
    {
        $heroBanners = Schema::hasTable('hero_banners')
            ? HeroBanner::where('is_active', true)->orderBy('display_order')->latest('id')->get()
            : collect();
        if (Schema::hasTable('projects')) {
            $recentProjects = Project::where('is_active', true)
                ->orderBy('display_order')
                ->latest('id')
                ->take(3)
                ->get();
        } else {
            $recentProjects = Gallery::query()
                ->where('type', 'image')
                ->whereNotNull('image')
                ->whereIn('id', function ($query) {
                    $query->selectRaw('MAX(id)')
                        ->from('galleries')
                        ->where('type', 'image')
                        ->whereNotNull('image')
                        ->groupBy('category');
                })
                ->latest()
                ->take(3)
                ->get()
                ->map(function ($project) {
                    $project->image_path = $project->image;
                    return $project;
                });
        }
        $homeGallery = Gallery::latest()->take(6)->get();
        $video = \App\Models\HomeVideo::first();
        $notices = \App\Models\Notice::latest()->get();
        $featuredCampaigns = collect();
        if (Schema::hasTable('campaigns')) {
            $featuredCampaigns = Campaign::where('status', 'published')
                ->where('visibility', 'public')
                ->where('is_featured', true)
                ->with(['media' => fn ($query) => $query
                    ->where('media_type', 'image')
                    ->orderBy('display_order')])
                ->orderBy('display_order')
                ->take(6)
                ->get();
        }

        return view('frontend.index', compact('heroBanners', 'recentProjects', 'homeGallery', 'video', 'notices', 'featuredCampaigns'));
    }
}
