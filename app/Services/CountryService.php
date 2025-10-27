<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\DB;
use App\Services\ImageService;

class CountryService
{
    public function __construct(
        private ExternalApiService $externalApi,
        private ImageService $imageService
    ) {}

    public function refreshCountries(): array
    {
        $countriesData = $this->externalApi->fetchCountries();
        $exchangeData = $this->externalApi->fetchExchangeRates();

        if (!$countriesData || !$exchangeData) {
            return [
                'success' => false,
                'error' => 'External data source unavailable',
                'details' => 'Could not fetch data from API'
            ];
        }

        $exchangeRates = $exchangeData['rates'] ?? [];
        $refreshedAt = now();
        $processedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($countriesData as $countryData) {
                // Handle countries with no currencies or multiple currencies
                $currencies = $countryData['currencies'] ?? [];

                if (empty($currencies)) {
                    continue; // Skip countries without currency data
                }

                // Get first currency code
                $currencyCode = $currencies[0]['code'] ?? null;

                if (!$currencyCode) {
                    continue;
                }

                // Get exchange rate (default to null if not found)
                $exchangeRate = $exchangeRates[$currencyCode] ?? null;

                // Calculate estimated GDP
                $population = $countryData['population'] ?? 0;
                $estimatedGdp = $exchangeRate && $population
                    ? $population * rand(1000, 2000) * $exchangeRate
                    : 0;

                // Update or create country
                Country::updateOrCreate(
                    ['name' => $countryData['name']],
                    [
                        'capital' => $countryData['capital'] ?? null,
                        'region' => $countryData['region'] ?? null,
                        'population' => $population,
                        'currency_code' => $currencyCode,
                        'exchange_rate' => $exchangeRate,
                        'estimated_gdp' => $estimatedGdp,
                        'flag_url' => $countryData['flag'] ?? null,
                        'last_refreshed_at' => $refreshedAt
                    ]
                );

                $processedCount++;
            }

            DB::commit();

            return [
                'success' => true,
                'countries_processed' => $processedCount,
                'last_refreshed_at' => $refreshedAt
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'error' => 'Internal server error',
                'details' => $e->getMessage()
            ];
        }
    }
    public function generateSummaryImage(): string
    {
        return $this->imageService->generateSummaryImage();
    }
}
