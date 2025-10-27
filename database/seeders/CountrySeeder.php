<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('countries')->truncate();

        $countries = [
            [
                'name' => 'Nigeria',
                'capital' => 'Abuja',
                'region' => 'Africa',
                'population' => 206139589,
                'currency_code' => 'NGN',
                'exchange_rate' => 1600.23,
                'estimated_gdp' => 329823448125.20,
                'flag_url' => 'https://flagcdn.com/ng.svg',
                'last_refreshed_at' => now(),
            ],
            [
                'name' => 'Ghana',
                'capital' => 'Accra',
                'region' => 'Africa',
                'population' => 31072945,
                'currency_code' => 'GHS',
                'exchange_rate' => 15.34,
                'estimated_gdp' => 47683456789.60,
                'flag_url' => 'https://flagcdn.com/gh.svg',
                'last_refreshed_at' => now(),
            ],
            [
                'name' => 'United States',
                'capital' => 'Washington, D.C.',
                'region' => 'Americas',
                'population' => 331002651,
                'currency_code' => 'USD',
                'exchange_rate' => 1.00,
                'estimated_gdp' => 529604305600.00,
                'flag_url' => 'https://flagcdn.com/us.svg',
                'last_refreshed_at' => now(),
            ],
            [
                'name' => 'United Kingdom',
                'capital' => 'London',
                'region' => 'Europe',
                'population' => 67886011,
                'currency_code' => 'GBP',
                'exchange_rate' => 0.79,
                'estimated_gdp' => 89745634567.89,
                'flag_url' => 'https://flagcdn.com/gb.svg',
                'last_refreshed_at' => now(),
            ],
            [
                'name' => 'Kenya',
                'capital' => 'Nairobi',
                'region' => 'Africa',
                'population' => 53771296,
                'currency_code' => 'KES',
                'exchange_rate' => 129.50,
                'estimated_gdp' => 95623456789.12,
                'flag_url' => 'https://flagcdn.com/ke.svg',
                'last_refreshed_at' => now(),
            ],
            [
                'name' => 'South Africa',
                'capital' => 'Pretoria',
                'region' => 'Africa',
                'population' => 59308690,
                'currency_code' => 'ZAR',
                'exchange_rate' => 18.65,
                'estimated_gdp' => 110723456789.45,
                'flag_url' => 'https://flagcdn.com/za.svg',
                'last_refreshed_at' => now(),
            ],
            [
                'name' => 'Germany',
                'capital' => 'Berlin',
                'region' => 'Europe',
                'population' => 83783942,
                'currency_code' => 'EUR',
                'exchange_rate' => 0.92,
                'estimated_gdp' => 154234567890.23,
                'flag_url' => 'https://flagcdn.com/de.svg',
                'last_refreshed_at' => now(),
            ],
            [
                'name' => 'Japan',
                'capital' => 'Tokyo',
                'region' => 'Asia',
                'population' => 126476461,
                'currency_code' => 'JPY',
                'exchange_rate' => 149.82,
                'estimated_gdp' => 237845678901.56,
                'flag_url' => 'https://flagcdn.com/jp.svg',
                'last_refreshed_at' => now(),
            ],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }

        $this->command->info('Countries seeded successfully!');
    }
}