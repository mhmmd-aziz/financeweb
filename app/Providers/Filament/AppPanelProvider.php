<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\App\Widgets\UserStatsOverview; // Import Widget Kita
use App\Filament\App\Widgets\IncomeExpenseChart; // Import Widget Kita
use App\Filament\App\Pages\Dashboard;
use App\Filament\App\Widgets\GoalsProgressChart;


class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->darkMode(true)
            ->id('app')
            ->path('app')
            ->login()
            ->registration()
            ->profile()
            ->colors([
                'primary' => \Filament\Support\Colors\Color::Indigo,
            ])
            ->font('Poppins')
            ->brandName('Keuanganku')
            ->brandLogo(asset('images/logo2b.png'))
            ->favicon(asset('images/logo2.png'))
            ->brandLogoHeight('3rem')
            ->darkmodeBrandLogo(asset('images/logoc.png'))
            
            // Konfigurasi Resource & Page
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\\Filament\\App\\Resources')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\\Filament\\App\\Pages')
            ->pages([
            Dashboard::class, // Pastikan ini mengarah ke App\Filament\App\Pages\Dashboard
        ])
            
            // Konfigurasi Widgets (PENTING)
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\\Filament\\App\\Widgets')
            ->widgets([
                // 1. Account Widget (Kotak Welcome)
                Widgets\AccountWidget::class,
                
                // 2. Statistik (Kotak Angka)
                UserStatsOverview::class,
                
                // 3. Grafik (Kotak Besar)
                IncomeExpenseChart::class,
                GoalsProgressChart::class,
            ])
            
            
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);

            
    }
}