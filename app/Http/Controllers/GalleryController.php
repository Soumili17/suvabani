<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PUBLIC PAGE (Grouped by category)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $gallery = Gallery::latest()->get();

        // group by category
        $grouped = $gallery->groupBy('category');

        return view('frontend.gallery_show', compact('grouped'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN LIST
    |--------------------------------------------------------------------------
    */
    public function adminIndex()
    {
        $images = Gallery::latest()->paginate(10);
        return view('frontend.gallery_admin', compact('images'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE FORM
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('dashboard.gallery.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE IMAGE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string',
            'image'    => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title'    => $request->title,
            'category' => $request->category,
            'image'    => $path,
        ]);

        return redirect()->route('dashboard.gallery')
                         ->with('success', 'Image uploaded successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $image = Gallery::findOrFail($id);

        if ($image->image) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return redirect()->route('dashboard.gallery')
                         ->with('success', 'Image deleted');
    }
}