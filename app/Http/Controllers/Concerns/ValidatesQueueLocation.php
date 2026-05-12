<?php

namespace App\Http\Controllers\Concerns;

trait ValidatesQueueLocation
{
    protected function queueLocationConfig(): array
    {
        return config('queue_location.location', []);
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