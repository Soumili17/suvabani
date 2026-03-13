<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use Barryvdh\DomPDF\Facade\Pdf;

class MembershipController extends Controller
{

// ======================
// STORE MEMBER
// ======================

public function submit(Request $request)
{

$photoPath = null;
$signaturePath = null;
$idfilePath = null;

if ($request->hasFile('photo')) {
$photoPath = $request->file('photo')->store('photos','public');
}

if ($request->hasFile('signature')) {
$signaturePath = $request->file('signature')->store('signatures','public');
}

if ($request->hasFile('idfile')) {
$idfilePath = $request->file('idfile')->store('idproofs','public');
}

$idproof = $request->idproof ? implode(',', $request->idproof) : null;
$membershipType = $request->membership ? implode(',', $request->membership) : null;
$membertype = $request->membertype ? implode(',', $request->membertype) : null;
$interest = $request->interest ? implode(',', $request->interest) : null;
$time = $request->time ? implode(',', $request->time) : null;

$member = Membership::create([

'photo'=>$photoPath,
'signature'=>$signaturePath,
'fullname'=>$request->fullname,
'parentname'=>$request->parentname,
'dob'=>$request->dob,
'gender'=>$request->gender,
'nationality'=>$request->nationality,
'occupation'=>$request->occupation,
'address'=>$request->address,
'phone'=>$request->phone,
'email'=>$request->email,

'idproof'=>$idproof,
'idproof_other'=>$request->idproof_other,
'idnumber'=>$request->idnumber,
'idfile'=>$idfilePath,

'membership'=>$membershipType,
'paidamount'=>$request->paidamount,
'membertype'=>$membertype,

'interest'=>$interest,
'interest_other'=>$request->interest_other,

'experience'=>$request->experience,
'languages'=>$request->languages,
'time'=>$time,
'reason'=>$request->reason,

'ref_name'=>$request->ref_name,
'ref_mobile'=>$request->ref_mobile,

'declaration_date'=>$request->declaration_date

]);

$pdf = Pdf::loadView('frontend.idcard',compact('member'))
->setPaper([0,0,520,400]);

return $pdf->download('membership_card_'.$member->id.'.pdf');

}


// ======================
// ADMIN LIST
// ======================

public function adminIndex(Request $request)
{

$query = Membership::query();

if($request->search){
$query->where('fullname','like','%'.$request->search.'%')
->orWhere('email','like','%'.$request->search.'%')
->orWhere('phone','like','%'.$request->search.'%');
}

$members = $query->latest()->paginate(15);

return view('layouts.members_view',compact('members'));

}


// ======================
// VIEW MEMBER
// ======================

public function view($id)
{
$member = Membership::findOrFail($id);

return view('layouts.member_view',compact('member'));
}


// ======================
// EDIT MEMBER
// ======================

public function edit($id)
{
$member = Membership::findOrFail($id);

return view('layouts.member_edit',compact('member'));
}


// ======================
// UPDATE MEMBER
// ======================

public function update(Request $request,$id)
{
    $member = Membership::findOrFail($id);

    $data = $request->all();

    if($request->hasFile('photo')){
        $data['photo'] = $request->file('photo')->store('photos','public');
    }

    if($request->hasFile('signature')){
        $data['signature'] = $request->file('signature')->store('signatures','public');
    }

    if($request->hasFile('idfile')){
        $data['idfile'] = $request->file('idfile')->store('idproofs','public');
    }

    $member->update($data);

    return redirect()->route('dashboard',['section'=>'members'])
        ->with('success','Member updated successfully');
}

// ======================
// DELETE MEMBER
// ======================

public function destroy($id)
{

$member = Membership::findOrFail($id);

$member->delete();

return redirect()->route('dashboard.members')
->with('success','Member deleted successfully');

}

}