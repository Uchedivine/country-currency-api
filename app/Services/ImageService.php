<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function generateSummaryImage(): string
    {
        // Get statistics
        $totalCountries = Country::count();
        $lastRefreshed = Country::max('last_refreshed_at');
        $topCountries = Country::orderBy('estimated_gdp', 'desc')->take(5)->get();

        // Create image
        $width = 800;
        $height = 600;
        $image = imagecreatetruecolor($width, $height);

        // Colors
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $blue = imagecolorallocate($image, 41, 128, 185);
        $gray = imagecolorallocate($image, 149, 165, 166);

        // Fill background
        imagefill($image, 0, 0, $white);

        // Title
        imagestring($image, 5, 250, 30, 'Country Currency API', $blue);
        imagestring($image, 3, 300, 60, 'Summary Report', $black);

        // Statistics
        imagestring($image, 3, 50, 120, "Total Countries: $totalCountries", $black);
        imagestring($image, 3, 50, 150, "Last Refreshed: " . ($lastRefreshed ?? 'Never'), $black);

        // Top 5 countries
        imagestring($image, 4, 50, 200, 'Top 5 Countries by Estimated GDP:', $blue);
        
        $y = 240;
        foreach ($topCountries as $index => $country) {
            $rank = $index + 1;
            $gdp = number_format($country->estimated_gdp, 2);
            $text = "$rank. {$country->name} - \${$gdp}";
            imagestring($image, 3, 70, $y, $text, $black);
            $y += 30;
        }

        // Timestamp
        imagestring($image, 2, 50, 550, 'Generated: ' . now()->toDateTimeString(), $gray);

        // Save image
        $directory = storage_path('app/public/cache');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = $directory . '/summary.png';
        imagepng($image, $path);
        imagedestroy($image);

        return $path;
    }
}