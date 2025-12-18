<?php

namespace App\Policies;

use App\Models\FinancialGoal;
use App\Models\User;

class FinancialGoalPolicy
{
    /**
     * Siapa yang boleh lihat daftar goal?
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Siapa yang boleh lihat detail 1 goal?
     */
    public function view(User $user, FinancialGoal $financialGoal): bool
    {
        return $user->id === $financialGoal->user_id;
    }

    /**
     * Siapa yang boleh buat goal baru?
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Siapa yang boleh edit?
     */
    public function update(User $user, FinancialGoal $financialGoal): bool
    {
        return $user->id === $financialGoal->user_id;
    }

    /**
     * Siapa yang boleh hapus?
     */
    public function delete(User $user, FinancialGoal $financialGoal): bool
    {
        return $user->id === $financialGoal->user_id;
    }
}