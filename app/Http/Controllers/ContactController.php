<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
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