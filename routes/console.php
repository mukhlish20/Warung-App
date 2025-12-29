<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cabang', function () {
    return 'HALAMAN CABANG ROUTE AKTIF';
});
