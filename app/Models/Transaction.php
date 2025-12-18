<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
    'user_id', 
    'category_id', // <-- Ganti 'category' jadi ini
    'name', 
    'type', 
    'amount', 
    'date', 
    'image',
    'note'
];


protected $casts = [
    'date' => 'date',
    'amount' => 'integer', // Atau decimal tergantung kebutuhan casting
];

public function user() {
    return $this->belongsTo(User::class);
}

// Relasi ke Category
public function category()
{
    return $this->belongsTo(Category::class);
}

}
