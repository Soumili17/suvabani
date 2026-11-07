<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Membership;
use App\Models\Contact;
use App\Models\HomeVideo;
use App\Models\Campaign;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    // Dashboard home
    public function index()
    {
        $stats = [
            'running_campaigns' => Schema::hasTable('campaigns')
                ? Campaign::whereIn('status', ['published', 'paused'])->where('visibility', 'public')->count()
                : 0,
            'total_donations' => Schema::hasTable('donations')
                ? (float) DB::table('donations')->whereIn('payment_status', ['Paid', 'paid'])->sum('amount')
                : 0,
            'active_members' => Schema::hasTable('memberships')
                ? (Schema::hasColumn('memberships', 'approval_status')
                    ? Membership::where('approval_status', 'Approved')->count()
                    : Membership::count())
                : 0,
            'successful_donors' => Schema::hasTable('donations')
                ? DB::table('donations')
                    ->whereIn('payment_status', ['Paid', 'paid'])
                    ->whereNotNull('donor_name')
                    ->distinct('donor_name')
                    ->count('donor_name')
                : 0,
        ];

        return view('layouts.dashboard', compact('stats'));
    }

    // Show all members
    public function members()
    {
        $members = Membership::latest()->get();
        return view('layouts.members_show', compact('members'));
    }

    // Delete a member
    public function deleteMember($id)
    {
        $member = Membership::findOrFail($id);
        $member->delete();
        return back()->with('success', 'Member deleted successfully!');
    }

    // Show all messages
    public function messages()
    {
        $messages = Contact::latest()->get();
        return view('layouts.message_show', compact('messages'));
    }

    // Delete a message
    public function deleteMessage($id)
    {
        $msg = Contact::findOrFail($id);
        $msg->delete();
        return back()->with('success', 'Message deleted successfully!');
    }

    // Show all donations


    public function donors()
    {
        $donors = Donation::latest()->get();
        return view('layouts.donors_show', compact('donors'));
    }

    // Delete a donor
    public function deleteDonor($id)
    {
        $donor = Donation::findOrFail($id);
        $donor->delete();
        return back()->with('success', 'Donation deleted successfully!');
    }

    // Home Video Settings
    public function editHomeVideo()
    {
        $video = HomeVideo::first();
        return view('layouts.home_video_edit', compact('video'));
    }

    public function updateHomeVideo(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'youtube_url' => 'required|url'
        ]);

        $video = HomeVideo::first();

        if ($video) {
            $video->update($request->all());
        } else {
            HomeVideo::create($request->all());
        }

        return back()->with('success', 'Home Video updated successfully!');
    }
}