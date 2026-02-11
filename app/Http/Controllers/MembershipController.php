<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class MembershipController extends Controller
{
    // List all members
    public function index()
    {
        $members = Membership::latest()->paginate(20);
        return view('admin.members.index', compact('members'));
    }

    // Show create member form
    public function create()
    {
        return view('admin.members.create');
    }

    // Store new member
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:memberships',
            'paid_amount'=>'nullable|numeric|min:0'
        ]);

        $member = Membership::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'membership_type'=>$request->membership_type,
            'paid_amount'=>$request->paid_amount ?? 0,
            'payment_status'=>'Success',
            'joining_date'=>now()
        ]);

        // Create membership invoice
        $invoice = Invoice::create([
            'user_id'=>$member->id,
            'type'=>'membership',
            'amount'=>$member->paid_amount,
            'invoice_number'=>'MEM'.time()
        ]);

        // Generate PDF invoice
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        $fileName = 'Invoice_'.$invoice->invoice_number.'.pdf';
        $pdf->save(storage_path('app/public/invoices/'.$fileName));
        $invoice->update(['pdf_path'=>'invoices/'.$fileName]);

        return redirect()->route('admin.members')->with('success','Member added successfully.');
    }

    // Edit member
    public function edit($id)
    {
        $member = Membership::findOrFail($id);
        return view('admin.members.edit', compact('member'));
    }

    // Update member
    public function update(Request $request, $id)
    {
        $member = Membership::findOrFail($id);
        $member->update($request->only('name','email','phone','address','membership_type','paid_amount','payment_status'));
        return redirect()->route('admin.members')->with('success','Member updated successfully.');
    }

    // Delete member
    public function destroy($id)
    {
        Membership::findOrFail($id)->delete();
        return redirect()->route('admin.members')->with('success','Member deleted successfully.');
    }
}




