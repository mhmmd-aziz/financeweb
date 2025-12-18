<?php

namespace App\Filament\App\Resources\FinancialGoalResource\Pages;

use App\Filament\App\Resources\FinancialGoalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFinancialGoal extends CreateRecord
{
    protected static string $resource = FinancialGoalResource::class;
}
