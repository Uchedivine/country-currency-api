<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Services\CountryService;
use App\Services\ImageService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(
        private CountryService $countryService,
        private ImageService $imageService
    ) {}

    public function refresh()
    {
        $result = $this->countryService->refreshCountries();

        if (!$result['success']) {
            return response()->json([
                'error' => $result['error'],
                'details' => $result['details']
            ], 503);
        }

        // Generate summary image
        try {
            $this->imageService->generateSummaryImage();
        } catch (\Exception $e) {
            \Log::error('Failed to generate summary image: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Countries refreshed successfully',
            'countries_processed' => $result['countries_processed'],
            'last_refreshed_at' => $result['last_refreshed_at']
        ], 200);
    }

    public function index(Request $request)
    {
        $query = Country::query();

        // Filter by region (case-insensitive)
        if ($request->has('region')) {
            $query->whereRaw('LOWER(region) = ?', [strtolower($request->region)]);
        }

        // Filter by currency
        if ($request->has('currency')) {
            $query->where('currency_code', strtoupper($request->currency));
        }

        // Sort by estimated GDP descending
        if ($request->has('sort') && $request->sort === 'gdp') {
            $query->orderBy('estimated_gdp', 'desc');
        } else {
            $query->orderBy('name', 'asc');
        }

        $countries = $query->get();

        return response()->json($countries, 200);
    }

    public function show(string $name)
    {
        $country = Country::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();

        if (!$country) {
            return response()->json([
                'error' => 'Country not found'
            ], 404);
        }

        return response()->json($country, 200);
    }

    public function destroy(string $name)
    {
        $country = Country::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();

        if (!$country) {
            return response()->json([
                'error' => 'Country not found'
            ], 404);
        }

        $country->delete();

        return response()->json([
            'message' => 'Country deleted successfully'
        ], 200);
    }

    public function status()
    {
        $totalCountries = Country::count();
        $lastRefreshed = Country::max('last_refreshed_at');

        return response()->json([
            'total_countries' => $totalCountries,
            'last_refreshed_at' => $lastRefreshed
        ], 200);
    }

    public function image()
    {
        $imagePath = storage_path('app/public/cache/summary.png');

        // Generate if not exists
        if (!file_exists($imagePath)) {
            try {
                $this->imageService->generateSummaryImage();
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Failed to generate image',
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->file($imagePath, [
            'Content-Type' => 'image/png',
        ]);
    }
}
