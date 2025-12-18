<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialGoal extends Model
{
    protected $fillable = [
    'user_id', 'title', 'target_amount', 'current_amount', 'target_date', 'image'
];

public function user() {
    return $this->belongsTo(User::class);
}

// Helper untuk persentase progress
public function getProgressAttribute() {
    if ($this->target_amount <= 0) return 0;
    return min(100, round(($this->current_amount / $this->target_amount) * 100));
}

}
