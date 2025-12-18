<?php

namespace App\Filament\App\Resources\TransactionResource\Pages;

use App\Filament\App\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Barryvdh\DomPDF\Facade\Pdf; // Import PDF Library
use App\Models\Transaction; // Import Model

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            
            // 1. Tombol Export Excel (Tetap pakai library Excel)
            ExportAction::make('exportExcel') 
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn ($resource) => 'Laporan-Keuangan-' . date('Y-m-d') . '.xlsx')
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                ]),

            // 2. Tombol Export PDF (KITA UBAH JADI ACTION BIASA)
            Actions\Action::make('cetakPdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-text')
                ->color('danger')
                ->action(function () {
                    // Ambil data transaksi milik user
                    $data = Transaction::where('user_id', auth()->id())
                        ->orderBy('date', 'desc')
                        ->get();
                    
                   
                    $pdf = Pdf::loadView('pdf.laporan_keuangan', ['transactions' => $data]);
                    
                    
                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'Laporan-Keuangan-' . date('Y-m-d') . '.pdf');
                }),
        ];
    }
}