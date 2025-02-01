<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class MedicineService
{
    public static function fetchMedicines()
    {
        $url = 'http://recruitment.rsdeltasurya.com/api/v1/medicines';
        $token = '9cf32855-ac91-4e98-9a0dec1b8d023eba|mf9afncxX8x4BsHXIsYTJoP3KsWFgceeMD64SD6B66e2b8e6';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($url);

        return $response->successful() ? $response->json()['medicines'] : [];
    }
}
