<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CountryController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

// Temporary migration endpoint
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

// Country API Routes (without /api prefix)
Route::post('/countries/refresh', [CountryController::class, 'refresh']);
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/image', [CountryController::class, 'image']);
Route::get('/countries/{name}', [CountryController::class, 'show']);
Route::delete('/countries/{name}', [CountryController::class, 'destroy']);
Route::get('/status', [CountryController::class, 'status']);