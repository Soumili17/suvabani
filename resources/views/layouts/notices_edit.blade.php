@extends('layouts.dashboard')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 style="color:#0f9d94; margin:0;">Edit Notice</h2>
    <a href="{{ route('dashboard.notices') }}" class="btn-action" style="background:#555;">← Back to Notices</a>
</div>

<form action="{{ route('dashboard.notices.update', $notice->id) }}" method="POST" enctype="multipart/form-data"
      style="max-width:600px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom:20px;">
        <label for="title" style="display:block; font-weight:600; margin-bottom:6px; color:#333;">
            Notice Title <span style="color:red;">*</span>
        </label>
        <input type="text" id="title" name="title" value="{{ old('title', $notice->title) }}"
               style="width:100%; padding:10px 14px; border:1px solid #ccc; border-radius:8px;
                      font-size:15px; outline:none; transition:border-color 0.2s;"
               onfocus="this.style.borderColor='#0f9d94'" onblur="this.style.borderColor='#ccc'"
               required>
        @error('title')
            <p style="color:red; font-size:13px; margin-top:4px;">{{ $message }}</p>
        @enderror
    </div>

    {{-- Current PDF --}}
    <div style="margin-bottom:20px; padding:14px 18px; background:#f0fafa; border-radius:10px;
                border:1px solid #c8ede9;">
        <p style="margin:0 0 8px; font-weight:600; color:#333;">Current PDF:</p>
        <div style="display:flex; align-items:center; gap:12px;">
            <i class="fas fa-file-pdf" style="font-size:24px; color:#dc3545;"></i>
            <span style="color:#555; font-size:14px;">{{ basename($notice->file_path) }}</span>
            <a href="{{ route('notices.view', $notice->id) }}" target="_blank"
               style="margin-left:auto; padding:5px 12px; background:#1a73e8; color:white;
                      border-radius:6px; text-decoration:none; font-size:13px;">
                View
            </a>
        </div>
    </div>

    {{-- Replace PDF (optional) --}}
    <div style="margin-bottom:24px;">
        <label for="pdf_file" style="display:block; font-weight:600; margin-bottom:6px; color:#333;">
            Replace PDF <span style="color:#888; font-weight:400;">(optional)</span>
        </label>

        <label for="pdf_file"
               style="display:flex; align-items:center; gap:12px; padding:14px 18px;
                      border:2px dashed #ccc; border-radius:10px; cursor:pointer;
                      background:#fafafa; transition:background 0.2s;"
               onmouseover="this.style.background='#f0fafa'; this.style.borderColor='#0f9d94'"
               onmouseout="this.style.background='#fafafa'; this.style.borderColor='#ccc'">
            <i class="fas fa-cloud-upload-alt" style="font-size:26px; color:#0f9d94;"></i>
            <div>
                <span id="file-label" style="font-size:15px; color:#555;">Click to choose a new PDF (optional)</span>
                <p style="font-size:12px; color:#777; margin:2px 0 0;">Max size: 10 MB. Leave blank to keep current file.</p>
            </div>
            <input type="file" id="pdf_file" name="pdf_file" accept="application/pdf"
                   style="display:none;"
                   onchange="document.getElementById('file-label').textContent = this.files[0]?.name || 'Click to choose a new PDF (optional)'">
        </label>

        @error('pdf_file')
            <p style="color:red; font-size:13px; margin-top:4px;">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit"
            style="padding:11px 28px; background:#0f9d94; color:white; border:none;
                   border-radius:8px; font-size:16px; font-weight:600; cursor:pointer;
                   transition:background 0.2s;"
            onmouseover="this.style.background='#0b8077'" onmouseout="this.style.background='#0f9d94'">
        <i class="fas fa-save" style="margin-right:8px;"></i> Save Changes
    </button>
</form>
@endsection
