<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroBanner;
use App\Models\Project;

class FrontPageController extends Controller
{
    public function index()
    {
        // Get all active hero banners and recent projects
        $heroBanners = HeroBanner::where('is_active', true)->get();
        $recentProjects = Project::where('is_active', true)->latest()->take(6)->get();

        return view('frontend.index', compact('heroBanners', 'recentProjects'));
    }
}

