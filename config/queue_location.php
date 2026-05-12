<?php

return [
    'location' => [
        'latitude' => (float) env('QUEUE_LOCATION_LATITUDE', 2.33758),
        'longitude' => (float) env('QUEUE_LOCATION_LONGITUDE', 99.079255),
        'radius_meters' => (int) env('QUEUE_LOCATION_RADIUS_METERS', 100),
    ],
];
