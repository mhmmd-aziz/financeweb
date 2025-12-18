<?php

namespace App\Observers;

use App\Models\FinancialGoal;
use App\Mail\GoalAchieved;
use Illuminate\Support\Facades\Mail;

class FinancialGoalObserver
{
    public function updated(FinancialGoal $financialGoal): void
    {
        // LOGIKA PENTING:
        // 1. Cek apakah tabungan sekarang SUDAH melebihi/sama dengan target.
        // 2. Cek apakah tabungan SEBELUMNYA masih kurang dari target.
        //    (Ini supaya email tidak dikirim berkali-kali kalau user edit data yang sudah lunas)
        
        $isAchievedNow = $financialGoal->current_amount >= $financialGoal->target_amount;
        $wasNotAchieved = $financialGoal->getOriginal('current_amount') < $financialGoal->target_amount;

        if ($isAchievedNow && $wasNotAchieved) {
            // Kirim Email ke User pemilik goal tersebut
            Mail::to($financialGoal->user)->send(new GoalAchieved($financialGoal));
        }
    }
}