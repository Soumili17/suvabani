<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Membership;
use App\Models\Contact;

class DashboardController extends Controller
{
    // Dashboard home
    public function index()
    {
        return view('layouts.dashboard');
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
}