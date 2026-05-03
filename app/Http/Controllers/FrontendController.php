<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $heroBanners = [];
        $recentProjects = [];
        $homeGallery = Gallery::latest()->take(6)->get();
        $video = \App\Models\HomeVideo::first();

        return view('frontend.index', compact('heroBanners', 'recentProjects', 'homeGallery', 'video'));
    }
}
