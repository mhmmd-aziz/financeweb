<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Pastikan ini ada
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // LOGIKA AKSES PANEL
    public function canAccessPanel(Panel $panel): bool
    {
        // Jika akses panel Admin
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        // Jika akses panel App (User)
        if ($panel->getId() === 'app') {
            // Kita perbolehkan Admin masuk juga (biar redirect scriptnya jalan)
            // Atau user biasa
            return true; 
        }

        return false;
    }
}