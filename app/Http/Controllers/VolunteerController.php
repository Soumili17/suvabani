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
        $volunteers = Volunteer::latest()->get(); // or paginate later
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

        // ✅ FIXED SEARCH (grouped properly)
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
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
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:volunteers,email',
            'phone'  => 'required|string|max:15',
            'id_card'=> 'required|image|mimes:jpeg,jpg|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('id_card')) {
            $path = $request->file('id_card')->store('id_cards', 'public');
        }

        Volunteer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'id_card' => $path,
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
        return view('dashboard.volunteers.edit', compact('volunteer'));
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
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:volunteers,email,' . $id,
            'phone'  => 'required|string|max:15',
            'id_card'=> 'nullable|image|mimes:jpeg,jpg|max:2048',
        ]);

        if ($request->hasFile('id_card')) {

            // delete old file
            if ($volunteer->id_card) {
                Storage::disk('public')->delete($volunteer->id_card);
            }

            $path = $request->file('id_card')->store('id_cards', 'public');
            $volunteer->id_card = $path;
        }

        $volunteer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
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

        if ($volunteer->id_card) {
            Storage::disk('public')->delete($volunteer->id_card);
        }

        $volunteer->delete();

        return redirect()->route('dashboard.volunteers')
                         ->with('success', 'Volunteer deleted');
    }
}