<?php

use Illuminate\Support\Facades\Route;

Route::get('/run-migrations', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
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