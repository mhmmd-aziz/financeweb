<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    // Ambil data hanya milik user yang login
    public function collection()
    {
        return Transaction::where('user_id', $this->userId)
            ->orderBy('date', 'desc')
            ->get();
    }

    // Header Kolom di Excel
    public function headings(): array
    {
        return [
            'Tanggal',
            'Jenis',
            'Nama Transaksi',
            'Kategori',
            'Nominal (IDR)',
            'Catatan',
        ];
    }

    // Mapping data per baris
    public function map($transaction): array
    {
        return [
            $transaction->date->format('d-m-Y'),
            $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
            $transaction->name,
            $transaction->category,
            $transaction->amount,
            $transaction->note ?? '-',
        ];
    }
}