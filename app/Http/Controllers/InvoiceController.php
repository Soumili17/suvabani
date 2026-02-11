<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    // Admin view all invoices
    public function index()
    {
        $invoices = Invoice::latest()->paginate(20);
        return view('admin.invoices.index', compact('invoices'));
    }

    // Download PDF invoice
    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);

        // Load Blade view and generate PDF
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        // Optional: save PDF to storage
        $fileName = 'Invoice_'.$invoice->invoice_number.'.pdf';
        $pdf->save(storage_path('app/public/invoices/'.$fileName));

        // Update database with PDF path
        $invoice->update([
            'pdf_path' => 'invoices/'.$fileName
        ]);

        return $pdf->download($fileName);
    }
}

