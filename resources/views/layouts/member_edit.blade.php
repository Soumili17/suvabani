@extends('layouts.dashboard')

@section('content')

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="mb-0">Edit Member Documents</h2>
        <p class="text-muted">Update photo, signature, or ID proof for {{ $member->fullname }}</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('dashboard.members.view', $member->id) }}" class="btn btn-secondary">
            &larr; Back to Member Details
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title fw-bold m-0"><i class="fas fa-file-upload me-2 text-primary"></i>Upload New Documents</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('dashboard.members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                
                {{-- PHOTO --}}
                <div class="col-md-4">
                    <div class="border rounded p-3 text-center h-100">
                        <label class="fw-bold mb-2 d-block text-secondary">Current Photo</label>
                        <img src="{{ asset('storage/'.$member->photo) }}" class="img-thumbnail mb-3" style="height: 120px; object-fit: cover;">
                        
                        <label class="form-label fw-bold mt-2">Replace Photo</label>
                        <input type="file" name="photo" class="form-control form-control-sm" accept="image/*">
                    </div>
                </div>

                {{-- SIGNATURE --}}
                <div class="col-md-4">
                    <div class="border rounded p-3 text-center h-100">
                        <label class="fw-bold mb-2 d-block text-secondary">Current Signature</label>
                        <img src="{{ asset('storage/'.$member->signature) }}" class="img-thumbnail mb-3" style="height: 120px; object-fit: contain;">
                        
                        <label class="form-label fw-bold mt-2">Replace Signature</label>
                        <input type="file" name="signature" class="form-control form-control-sm" accept="image/*">
                    </div>
                </div>

                {{-- ID PROOF --}}
                <div class="col-md-4">
                    <div class="border rounded p-3 text-center h-100">
                        <label class="fw-bold mb-2 d-block text-secondary">Current ID Proof</label>
                        @php
                            $ext = pathinfo($member->idfile, PATHINFO_EXTENSION);
                        @endphp
                        @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                            <img src="{{ asset('storage/'.$member->idfile) }}" class="img-thumbnail mb-3" style="height: 120px; object-fit: cover;">
                        @else
                            <div class="mb-3 d-flex align-items-center justify-content-center bg-light rounded" style="height: 120px;">
                                <a href="{{ asset('storage/'.$member->idfile) }}" target="_blank" class="btn btn-sm btn-outline-primary">View Current File</a>
                            </div>
                        @endif
                        
                        <label class="form-label fw-bold mt-2">Replace {{ strtoupper($member->idproof) }}</label>
                        <input type="file" name="idfile" class="form-control form-control-sm" accept="image/*,.pdf">
                    </div>
                </div>

            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary px-4 fw-bold">Save Changes</button>
            </div>
            
        </form>
    </div>
</div>

@endsection