<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/export/pdf', [ReportController::class, 'downloadPdf'])->name('export.pdf');
    Route::get('/export/excel', [ReportController::class, 'downloadExcel'])->name('export.excel');
});
