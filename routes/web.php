<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Penjaga\OmsetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Penjaga\DashboardController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Owner\RekapController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Owner\WarungController;
use App\Http\Controllers\Owner\PenjagaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Owner\WhatsAppSettingController;

/*route welcome - redirect to login or dashboard based on auth*/
Route::get('/', function () {
    if (auth()->check()) {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (auth()->user()->role === 'owner') {
            return redirect()->route('owner.dashboard');
        } else {
            return redirect()->route('penjaga.dashboard');
        }
    }

    // Jika belum login, redirect ke halaman login
    return redirect()->route('login');
});

/*route login & logout*/
Route::get('/login', [LoginController::class, 'form'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

/*route penjaga*/
Route::middleware(['auth', 'penjaga'])
    ->prefix('penjaga')
    ->name('penjaga.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/omset', [OmsetController::class, 'index'])
            ->name('omset.index');

        Route::post('/omset', [OmsetController::class, 'store'])
            ->name('omset.store');
    });

        

        Route::middleware('auth')->group(function () {
            Route::get('/akun-saya', [ProfileController::class, 'index'])
                ->name('profile.index');

            Route::post('/akun-saya', [ProfileController::class, 'update'])
                ->name('profile.update');
        });


// OWNER
Route::middleware(['auth', 'owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [\App\Http\Controllers\Owner\DashboardController::class, 'index'])
            ->name('dashboard');

        // REKAP
        Route::get('/rekap', [\App\Http\Controllers\Owner\RekapController::class, 'index'])
            ->name('rekap');

        // REKAP EXPORT
        Route::get('/rekap/excel', [RekapController::class, 'exportExcel'])
            ->name('rekap.excel');

        Route::get('/rekap/pdf', [RekapController::class, 'exportPdf'])
            ->name('rekap.pdf');

        // WARUNG (menggunakan resource route)
        Route::resource('warung', \App\Http\Controllers\Owner\WarungController::class);

        // PENJAGA
        Route::get('/penjaga', [PenjagaController::class, 'index'])
            ->name('penjaga.index');

        Route::get('/penjaga/create', [PenjagaController::class, 'create'])
            ->name('penjaga.create');

        Route::post('/penjaga', [PenjagaController::class, 'store'])
            ->name('penjaga.store');

        Route::get('/penjaga/{user}/edit', [PenjagaController::class, 'edit'])
            ->name('penjaga.edit');

        Route::put('/penjaga/{user}', [PenjagaController::class, 'update'])
            ->name('penjaga.update');

        Route::delete('/penjaga/{user}/unassign',
            [PenjagaController::class, 'unassign']
        )->name('penjaga.unassign');

        Route::get('/penjaga/{user}/reset-password',
            [PenjagaController::class, 'resetPasswordForm']
        )->name('penjaga.reset.form');

        Route::put('/penjaga/{user}/reset-password',
            [PenjagaController::class, 'resetPassword']
        )->name('penjaga.reset');

        Route::put('/penjaga/{user}/toggle-active',
            [PenjagaController::class, 'toggleActive']
        )->name('penjaga.toggle');

        // WHATSAPP SETTING
        Route::get('/whatsapp-setting', [WhatsAppSettingController::class, 'index'])
            ->name('whatsapp.setting');

        Route::post('/whatsapp/test', [WhatsAppSettingController::class, 'testConnection'])
            ->name('whatsapp.test');

        Route::post('/whatsapp/test-alert', [WhatsAppSettingController::class, 'sendTestAlert'])
            ->name('whatsapp.test-alert');

    });

/*route forgot password*/
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showForm'])
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');
