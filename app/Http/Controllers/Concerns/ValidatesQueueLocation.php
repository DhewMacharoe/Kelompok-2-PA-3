<?php

namespace App\Http\Controllers\Concerns;

trait ValidatesQueueLocation
{
    protected function queueLocationConfig(): array
    {
        $defaultConfig = config('queue_location.location', []);
        
        try {
            $latitude = \App\Models\Setting::get('queue_latitude', $defaultConfig['latitude'] ?? 2.33758);
            $longitude = \App\Models\Setting::get('queue_longitude', $defaultConfig['longitude'] ?? 99.079255);
            $radius = \App\Models\Setting::get('queue_radius_meters', $defaultConfig['radius_meters'] ?? 100);
            
            return [
                'latitude' => (float) $latitude,
                'longitude' => (float) $longitude,
                'radius_meters' => (int) $radius,
            ];
        } catch (\Exception $e) {
            return $defaultConfig;
        }
    }

    protected function distanceInMeters(float $fromLatitude, float $fromLongitude, float $toLatitude, float $toLongitude): float
    {
        $earthRadius = 6371000;

        $latitudeDifference = deg2rad($toLatitude - $fromLatitude);
        $longitudeDifference = deg2rad($toLongitude - $fromLongitude);

        $a = sin($latitudeDifference / 2) * sin($latitudeDifference / 2)
            + cos(deg2rad($fromLatitude)) * cos(deg2rad($toLatitude))
            * sin($longitudeDifference / 2) * sin($longitudeDifference / 2);

        return $earthRadius * (2 * atan2(sqrt($a), sqrt(1 - $a)));
    }
}