<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('getLocationFromIp')) {
    function getLocationFromIp($ip)
    {
        try {
            $response = Http::get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                $data = $response->json();
                return "{$data['city']}, {$data['regionName']}, {$data['country']}";
            }
        } catch (\Exception $e) {
            return 'Location not available';
        }

        return 'Location not available';
    }
}
