@extends('layouts.dashboard')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 style="color:#0f9d94; margin:0;">Upload New Notice</h2>
    <a href="{{ route('dashboard.notices') }}" class="btn-action" style="background:#555;">← Back to Notices</a>
</div>

<form action="{{ route('dashboard.notices.store') }}" method="POST" enctype="multipart/form-data"
      style="max-width:600px;">
    @csrf

    <div style="margin-bottom:20px;">
        <label for="title" style="display:block; font-weight:600; margin-bottom:6px; color:#333;">
            Notice Title <span style="color:red;">*</span>
        </label>
        <input type="text" id="title" name="title" value="{{ old('title') }}"
               placeholder="e.g. Annual Report 2024"
               style="width:100%; padding:10px 14px; border:1px solid #ccc; border-radius:8px;
                      font-size:15px; outline:none; transition:border-color 0.2s;"
               onfocus="this.style.borderColor='#0f9d94'" onblur="this.style.borderColor='#ccc'"
               required>
        @error('title')
            <p style="color:red; font-size:13px; margin-top:4px;">{{ $message }}</p>
        @enderror
    </div>

    <div style="margin-bottom:24px;">
        <label for="pdf_file" style="display:block; font-weight:600; margin-bottom:6px; color:#333;">
            PDF File <span style="color:red;">*</span>
        </label>

        <label for="pdf_file"
               style="display:flex; align-items:center; gap:12px; padding:14px 18px;
                      border:2px dashed #0f9d94; border-radius:10px; cursor:pointer;
                      background:#f0fafa; transition:background 0.2s;"
               onmouseover="this.style.background='#dff5f4'" onmouseout="this.style.background='#f0fafa'">
            <i class="fas fa-file-pdf" style="font-size:28px; color:#dc3545;"></i>
            <div>
                <span id="file-label" style="font-size:15px; color:#333;">Click to choose a PDF file</span>
                <p style="font-size:12px; color:#777; margin:2px 0 0;">Max size: 10 MB</p>
            </div>
            <input type="file" id="pdf_file" name="pdf_file" accept="application/pdf"
                   style="display:none;" required
                   onchange="document.getElementById('file-label').textContent = this.files[0]?.name || 'Click to choose a PDF file'">
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
        <i class="fas fa-upload" style="margin-right:8px;"></i> Upload Notice
    </button>
</form>
@endsection
