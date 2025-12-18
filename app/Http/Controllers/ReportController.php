<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function downloadPdf()
    {
        // 1. Ambil data user yang login
        $transactions = Transaction::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->get();

        // 2. Load view dan pass data
        $pdf = Pdf::loadView('pdf.transactions', compact('transactions'));

        // 3. Download file
        return $pdf->download('laporan-keuangan-' . now()->format('Y-m-d') . '.pdf');
    }

    public function downloadExcel()
    {
        // Panggil class Export yang sudah kita buat tadi
        return Excel::download(new TransactionExport(auth()->id()), 'laporan-keuangan.xlsx');
    }
}