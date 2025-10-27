<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CountryController;


Route::post('/countries/refresh', [CountryController::class, 'refresh']);


Route::get('/countries', [CountryController::class, 'index']);


Route::get('/status', [CountryController::class, 'status']);


Route::get('/countries/image', [CountryController::class, 'image']);


Route::get('/countries/{name}', [CountryController::class, 'show']);


Route::delete('/countries/{name}', [CountryController::class, 'destroy']);