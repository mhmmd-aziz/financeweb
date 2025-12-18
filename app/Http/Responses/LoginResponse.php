<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        // Cek Role User yang baru saja login
        if (auth()->user()->role === 'admin') {
            // Jika Admin, paksa ke Panel Admin
            return redirect()->to('/admin');
        }

        // Jika User biasa, paksa ke Panel App
        return redirect()->to('/app');
    }
}