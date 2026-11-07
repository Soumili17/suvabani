<?php

namespace App\Http\Controllers;

use App\Models\VolunteerInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VolunteerInquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:30',
            'alt_mobile_no' => 'nullable|string|max:30',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:1000',
            'pin_code' => 'required|string|max:10',
            'aadhar_card' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'pan_card' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['aadhar_card_path'] = $request->file('aadhar_card')->store('volunteer-inquiries/aadhar');
        $validated['pan_card_path'] = $request->file('pan_card')->store('volunteer-inquiries/pan');
        $validated['image_path'] = $request->file('image')->store('volunteer-inquiries/images', 'public');

        unset($validated['aadhar_card'], $validated['pan_card'], $validated['image']);

        VolunteerInquiry::create($validated);

        return redirect()->route('volunteers')
            ->with('inquiry_success', 'Thank you for reaching out. We will get back to you soon.');
    }

    public function adminIndex(Request $request)
    {
        $query = VolunteerInquiry::query();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile_no', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->latest()->paginate(10)->withQueryString();

        return view('layouts.volunteer_inquiries', compact('inquiries'));
    }

    public function downloadDocument($id, string $document)
    {
        $inquiry = VolunteerInquiry::findOrFail($id);
        $paths = [
            'aadhar' => $inquiry->aadhar_card_path,
            'pan' => $inquiry->pan_card_path,
        ];

        abort_unless(isset($paths[$document]), 404);

        return Storage::disk('local')->download($paths[$document]);
    }

    public function destroy($id)
    {
        $inquiry = VolunteerInquiry::findOrFail($id);

        foreach (['aadhar_card_path', 'pan_card_path', 'image_path'] as $path) {
            if ($inquiry->{$path}) {
                Storage::disk($path === 'image_path' ? 'public' : 'local')->delete($inquiry->{$path});
            }
        }

        $inquiry->delete();

        return redirect()->route('dashboard.volunteer_inquiries')
            ->with('success', 'Volunteer inquiry deleted successfully.');
    }
}
