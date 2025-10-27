<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalApiService
{
    private const COUNTRIES_API = 'https://restcountries.com/v2/all?fields=name,capital,region,population,flag,currencies';
    private const EXCHANGE_API = 'https://open.er-api.com/v6/latest/USD';

    public function fetchCountries(): ?array
    {
        try {
            Log::info('Attempting to fetch countries from: ' . self::COUNTRIES_API);
            
            $response = Http::timeout(30)
                ->withOptions(['verify' => false]) // Disable SSL verification for testing
                ->get(self::COUNTRIES_API);
            
            if ($response->successful()) {
                Log::info('Successfully fetched countries');
                return $response->json();
            }
            
            Log::error('Failed to fetch countries', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Exception fetching countries', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    public function fetchExchangeRates(): ?array
    {
        try {
            Log::info('Attempting to fetch exchange rates from: ' . self::EXCHANGE_API);
            
            $response = Http::timeout(30)
                ->withOptions(['verify' => false]) // Disable SSL verification for testing
                ->get(self::EXCHANGE_API);
            
            if ($response->successful()) {
                Log::info('Successfully fetched exchange rates');
                return $response->json();
            }
            
            Log::error('Failed to fetch exchange rates', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Exception fetching exchange rates', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }
}