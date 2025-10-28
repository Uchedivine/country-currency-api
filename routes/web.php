<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fresh-migrate', function () {
    try {
        Artisan::call('migrate:fresh', ['--force' => true]);
        return response()->json([
            'success' => true,
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});