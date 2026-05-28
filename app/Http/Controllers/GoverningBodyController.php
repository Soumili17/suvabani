<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoverningBody;
use Illuminate\Support\Facades\Storage;

class GoverningBodyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = GoverningBody::orderBy('order', 'asc')->get();
        return view('layouts.governing_body_show', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.governing_body_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'post' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('governing_bodies', 'public');
        }

        GoverningBody::create([
            'name' => $request->name,
            'post' => $request->post,
            'description' => $request->description,
            'order' => $request->order,
            'image' => $path,
        ]);

        return redirect()->route('dashboard.governing_body.index')
                         ->with('success', 'Governing Body member added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = GoverningBody::findOrFail($id);
        return view('layouts.governing_body_edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = GoverningBody::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'post' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old file if exists
            if ($member->image) {
                Storage::disk('public')->delete($member->image);
            }
            $path = $request->file('image')->store('governing_bodies', 'public');
            $member->image = $path;
        }

        $member->name = $request->name;
        $member->post = $request->post;
        $member->description = $request->description;
        $member->order = $request->order;
        $member->save();

        return redirect()->route('dashboard.governing_body.index')
                         ->with('success', 'Governing Body member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = GoverningBody::findOrFail($id);

        if ($member->image) {
            Storage::disk('public')->delete($member->image);
        }

        $member->delete();

        return redirect()->route('dashboard.governing_body.index')
                         ->with('success', 'Governing Body member deleted successfully.');
    }
}
