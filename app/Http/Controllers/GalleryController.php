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
        return view('frontend.gallery_admin', [
            'images' => Gallery::latest()->paginate(10),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (Image OR YouTube)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string',
            'type'        => 'required|in:image,youtube',
            'image'       => 'required_if:type,image|image|mimes:jpeg,jpg,png|max:2048',
            'video_url'   => 'required_if:type,youtube|url',
        ]);

        $data = [
            'title'    => $request->title,
            'category' => $request->category,
            'type'     => $request->type,
        ];

        // IMAGE UPLOAD
        if ($request->type === 'image') {
            $path = $request->file('image')->store('gallery', 'public');
            $data['image'] = $path;
        }

        // YOUTUBE LINK
        if ($request->type === 'youtube') {
            $data['video_url'] = $request->video_url;
        }

        Gallery::create($data);

        return redirect()->route('dashboard.gallery')
                         ->with('success', 'Uploaded successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT FORM
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);

        return view('frontend.gallery_edit', compact('gallery'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $item = Gallery::findOrFail($id);

        $imageRule = ($request->type === 'image' && !$item->image)
            ? 'required|image|mimes:jpeg,jpg,png|max:2048'
            : 'nullable|image|mimes:jpeg,jpg,png|max:2048';

        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string',
            'type'        => 'required|in:image,youtube',
            'image'       => $imageRule,
            'video_url'   => 'nullable|required_if:type,youtube|url',
        ]);

        $data = [
            'title'    => $request->title,
            'category' => $request->category,
            'type'     => $request->type,
        ];

        if ($request->type === 'image') {
            $data['video_url'] = null;

            if ($request->hasFile('image')) {
                if ($item->image) {
                    Storage::disk('public')->delete($item->image);
                }

                $data['image'] = $request->file('image')->store('gallery', 'public');
            }
        }

        if ($request->type === 'youtube') {
            if ($item->type === 'image' && $item->image) {
                Storage::disk('public')->delete($item->image);
            }

            $data['image'] = null;
            $data['video_url'] = $request->video_url;
        }

        $item->update($data);

        return redirect()->route('dashboard.gallery')
                         ->with('success', 'Gallery item updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $item = Gallery::findOrFail($id);

        // Delete image file only if type = image
        if ($item->type === 'image' && $item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('dashboard.gallery')
                         ->with('success', 'Deleted successfully');
    }
}
