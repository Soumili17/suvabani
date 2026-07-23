<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * List all notices in the admin dashboard.
     */
    public function adminIndex()
    {
        $notices = Notice::latest()->get();
        return view('layouts.notices_index', compact('notices'));
    }

    /**
     * Show the form to create a new notice.
     */
    public function create()
    {
        return view('layouts.notices_create');
    }

    /**
     * Store a new notice (title, description, and PDF upload).
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'pdf_file' => 'required|file|mimes:pdf|max:10240', // max 10 MB
        ]);

        $path = $request->file('pdf_file')->store('notices', 'public');

        Notice::create([
            'title'     => $request->title,
            'description' => $request->description,
            'file_path' => $path,
        ]);

        return redirect()->route('dashboard.notices')->with('success', 'Notice uploaded successfully.');
    }

    /**
     * Show the form to edit an existing notice.
     */
    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        return view('layouts.notices_edit', compact('notice'));
    }

    /**
     * Update a notice (title, description, and optionally replace the PDF).
     */
    public function update(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);

        $request->validate([
            'title'    => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $notice->title = $request->title;
        $notice->description = $request->description;

        if ($request->hasFile('pdf_file')) {
            // Delete old file
            Storage::disk('public')->delete($notice->file_path);
            // Store new file
            $notice->file_path = $request->file('pdf_file')->store('notices', 'public');
        }

        $notice->save();

        return redirect()->route('dashboard.notices')->with('success', 'Notice updated successfully.');
    }

    /**
     * Delete a notice and its associated PDF file.
     */
    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);
        Storage::disk('public')->delete($notice->file_path);
        $notice->delete();

        return redirect()->route('dashboard.notices')->with('success', 'Notice deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLIC METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Serve the PDF for inline viewing in the browser.
     */
    public function view($id)
    {
        $notice = Notice::findOrFail($id);
        $filePath = storage_path('app/public/' . $notice->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'Notice file not found.');
        }

        return response()->file($filePath, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($notice->file_path) . '"',
        ]);
    }

    /**
     * Serve the PDF as a download.
     */
    public function download($id)
    {
        $notice = Notice::findOrFail($id);
        $filePath = storage_path('app/public/' . $notice->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'Notice file not found.');
        }

        $safeTitle = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $notice->title);
        return response()->download($filePath, $safeTitle . '.pdf');
    }
}
