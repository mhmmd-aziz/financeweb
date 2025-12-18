<?php

namespace App\Filament\App\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\FinancialGoal;

class GoalsProgressChart extends ChartWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;

    // 👇 PERBAIKAN: Ubah dari 'protected' menjadi 'public'
    public function getHeading(): ?string
    {
        $userId = auth()->id();
        $activeFilter = $this->filter;

        if (! $activeFilter) {
            $firstGoal = FinancialGoal::where('user_id', $userId)->first();
            $activeFilter = $firstGoal?->id;
        }

        if ($activeFilter) {
            $goal = FinancialGoal::find($activeFilter);
            if ($goal) {
                return 'Progress: ' . $goal->title;
            }
        }

        return 'Progress Target Impian';
    }

    protected function getFilters(): ?array
    {
        $userId = auth()->id();
        return FinancialGoal::where('user_id', $userId)
            ->pluck('title', 'id')
            ->toArray();
    }

    protected function getData(): array
    {
        $userId = auth()->id();
        $activeFilter = $this->filter;
        
        // Default ke goal pertama jika filter kosong
        if (! $activeFilter) {
            $firstGoal = FinancialGoal::where('user_id', $userId)->first();
            if ($firstGoal) {
                $activeFilter = $firstGoal->id;
            } else {
                return ['datasets' => [], 'labels' => []];
            }
        }

        $goal = FinancialGoal::find($activeFilter);

        if (! $goal) {
            return [];
        }

        $remaining = max(0, $goal->target_amount - $goal->current_amount);
        
        return [
            'datasets' => [
                [
                    'label' => 'Progress',
                    'data' => [$goal->current_amount, $remaining],
                    'backgroundColor' => [
                        '#10b981', // Hijau
                        '#e5e7eb', // Abu-abu
                    ],
                    'hoverOffset' => 4,
                ],
            ],
            'labels' => ['Terkumpul', 'Kekurangan'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}