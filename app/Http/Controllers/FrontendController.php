<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $heroBanners = [];
        $recentProjects = [];

        return view('frontend.index', compact('heroBanners', 'recentProjects'));
    }
}

