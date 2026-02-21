<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use Barryvdh\DomPDF\Facade\Pdf;

class MembershipController extends Controller
{
    public function submit(Request $request)
    {
        // ======================
        // FILE UPLOAD
        // ======================

        $photoPath = null;
        $signaturePath = null;
        $idfilePath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        if ($request->hasFile('signature')) {
            $signaturePath = $request->file('signature')->store('signatures', 'public');
        }

        if ($request->hasFile('idfile')) {
            $idfilePath = $request->file('idfile')->store('idproofs', 'public');
        }

        // ======================
        // ARRAY → STRING
        // ======================

        $idproof    = $request->idproof ? implode(',', $request->idproof) : null;
        $membershipType = $request->membership ? implode(',', $request->membership) : null;
        $membertype = $request->membertype ? implode(',', $request->membertype) : null;
        $interest   = $request->interest ? implode(',', $request->interest) : null;
        $time       = $request->time ? implode(',', $request->time) : null;

        // ======================
        // SAVE DATA
        // ======================

        $member = Membership::create([
            'photo'            => $photoPath,
            'signature'        => $signaturePath,
            'fullname'         => $request->fullname,
            'parentname'       => $request->parentname,
            'dob'              => $request->dob,
            'gender'           => $request->gender,
            'nationality'      => $request->nationality,
            'occupation'       => $request->occupation,
            'address'          => $request->address,
            'phone'            => $request->phone,
            'email'            => $request->email,
            'idproof'          => $idproof,
            'membership'       => $membershipType,
            'membertype'       => $membertype,
            'interest'         => $interest,
            'time'             => $time,
            'idproof_other'    => $request->idproof_other,
            'idnumber'         => $request->idnumber,
            'idfile'           => $idfilePath,
            'paidamount'       => $request->paidamount ?? 0,
            'interest_other'   => $request->interest_other,
            'experience'       => $request->experience,
            'languages'        => $request->languages,
            'reason'           => $request->reason,
            'ref_name'         => $request->ref_name,
            'ref_mobile'       => $request->ref_mobile,
            'declaration_date' => $request->declaration_date,
        ]);

        // ======================
        // GENERATE PDF
        // ======================

        $pdf = Pdf::loadView('frontend.idcard', compact('member'))
          ->setPaper([0,0,520,400]);

return $pdf->download('membership_card_'.$member->id.'.pdf');

    }
    public function edit($id)
    {
        $member = Membership::findOrFail($id);
        return view('layouts.edit_member',compact('member'));
    }

    public function update(Request $request,$id)
    {
        $member = Membership::findOrFail($id);
        $member->update($request->all()); // For simplicity, you can validate & filter

        return redirect()->route('dashboard',['section'=>'members'])
                         ->with('success','Member updated successfully');
    }

    public function destroy($id)
    {
        $member = Membership::findOrFail($id);
        $member->delete();

        return redirect()->route('dashboard',['section'=>'members'])
                         ->with('success','Member deleted successfully');
    }
}
