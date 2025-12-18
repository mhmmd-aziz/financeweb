<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    /**
     * Siapa yang boleh lihat daftar transaksi? (Semua user login boleh)
     */
    public function viewAny(User $user): bool
    {
        return true; 
    }

    /**
     * Siapa yang boleh lihat detail 1 transaksi?
     * HANYA jika ID user sama dengan ID pemilik transaksi.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->user_id;
    }

    /**
     * Siapa yang boleh buat transaksi baru? (Semua user login boleh)
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Siapa yang boleh edit? (HANYA pemilik)
     */
    public function update(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->user_id;
    }

    /**
     * Siapa yang boleh hapus? (HANYA pemilik)
     */
    public function delete(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->user_id;
    }
}