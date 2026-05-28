<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\GoverningBody;

class ContactController extends Controller
{
    public function index()
    {
        $governingBodies = GoverningBody::orderBy('order', 'asc')->get();
        return view('frontend.contact', compact('governingBodies'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);
    
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ]);
    
        return redirect()->route('home')
                         ->with('success', 'Message sent successfully!');
    }
    public function destroy($id)
    {
        $msg = Contact::findOrFail($id);
        $msg->delete();
        return redirect()->route('dashboard',['section'=>'messages'])
                         ->with('success','Message deleted successfully');
    }
}