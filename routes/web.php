<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SipersuratController;

Route::controller(SipersuratController::class)->group(function () {
    // Auth Routes
    Route::get('/', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::get('/logout', 'logout')->name('logout');

    // Protected Routes (handled in controller for simplicity in this no-auth-scaffold setup)
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/surat-masuk', 'suratMasuk')->name('surat-masuk');
    Route::get('/surat-masuk/create', 'createSuratMasuk')->name('surat-masuk.create');
    Route::post('/surat-masuk', 'storeSuratMasuk')->name('surat-masuk.store');
    Route::get('/surat-masuk/{id}/edit', 'editSuratMasuk')->name('surat-masuk.edit');
    Route::put('/surat-masuk/{id}', 'updateSuratMasuk')->name('surat-masuk.update');
    Route::delete('/surat-masuk/{id}', 'destroySuratMasuk')->name('surat-masuk.destroy');
    
    Route::get('/surat-keluar', 'suratKeluar')->name('surat-keluar');
    Route::get('/surat-keluar/create', 'createSuratKeluar')->name('surat-keluar.create');
    Route::post('/surat-keluar', 'storeSuratKeluar')->name('surat-keluar.store');
    Route::get('/surat-keluar/{id}/edit', 'editSuratKeluar')->name('surat-keluar.edit');
    Route::put('/surat-keluar/{id}', 'updateSuratKeluar')->name('surat-keluar.update');
    Route::delete('/surat-keluar/{id}', 'destroySuratKeluar')->name('surat-keluar.destroy');

    Route::get('/surat-masuk/{id}/file', 'downloadSuratMasukFile')->name('surat-masuk.file');
    Route::get('/surat-keluar/{id}/file', 'downloadSuratKeluarFile')->name('surat-keluar.file');
    
    Route::get('/disposisi/{id}', 'disposisi')->name('disposisi');
    Route::post('/disposisi/{id}', 'storeDisposisi')->name('disposisi.store');
    Route::post('/disposisi/{id}/finish', 'finishDisposisi')->name('disposisi.finish');
    
    Route::get('/arsip', 'arsip')->name('arsip');
    
    Route::get('/profile', 'profile')->name('profile');
    Route::put('/profile', 'updateProfile')->name('profile.update');
});
