<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Storage;

class VolunteerController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    | PUBLIC PAGE (Frontend)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $volunteers = Volunteer::latest()->get();
        return view('frontend.volentire', compact('volunteers'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN LIST (Dashboard)
    |--------------------------------------------------------------------------
    */
    public function adminIndex(Request $request)
    {
        $query = Volunteer::query();

        // Search by name or designation only
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('designation', 'like', '%' . $request->search . '%');
            });
        }

        $volunteers = $query->latest()->paginate(10);

        return view('layouts.volenteer_show', compact('volunteers'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE FORM
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('layouts.volenteer_create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'profile_pic' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
        }

        Volunteer::create([
            'name'        => $request->name,
            'designation' => $request->designation,
            'profile_pic' => $path,
        ]);

        return redirect()->route('dashboard.volunteers')
                         ->with('success', 'Volunteer added successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT FORM
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        return view('layouts.volenteer_edit', compact('volunteer'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $volunteer = Volunteer::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'profile_pic' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($request->hasFile('profile_pic')) {
            // Delete old file
            if ($volunteer->profile_pic) {
                Storage::disk('public')->delete($volunteer->profile_pic);
            }

            $volunteer->profile_pic = $request->file('profile_pic')->store('profile_pics', 'public');
        }

        $volunteer->update([
            'name'        => $request->name,
            'designation' => $request->designation,
        ]);

        return redirect()->route('dashboard.volunteers')
                         ->with('success', 'Volunteer updated');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $volunteer = Volunteer::findOrFail($id);

        if ($volunteer->profile_pic) {
            Storage::disk('public')->delete($volunteer->profile_pic);
        }

        $volunteer->delete();

        return redirect()->route('dashboard.volunteers')
                         ->with('success', 'Volunteer deleted');
    }
}