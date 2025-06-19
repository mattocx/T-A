<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Fonnte
{
    public static function send($phone, $message)
    {
        $token = env('FONNTE_TOKEN');

        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $phone,
            'message' => $message,
            'countryCode' => '62',
        ]);

        return $response->json();
    }
}
