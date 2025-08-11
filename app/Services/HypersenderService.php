<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HypersenderService
{
    static function sendMessage($phone, $message)
    {
        try {
            $apiKey = env('HYPERSENDER_API_KEY');
            $deviceId = env('HYPERSENDER_INSTANCE_ID');
            $baseUrl = env('HYPERSENDER_BASEURL');

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
            ])->post("{$baseUrl}/{$deviceId}/send-text-safe", [
                "chatId" => "{$phone}@c.us",
                "text" => $message,
                "reply_to" => "string",
                "link_preview" => false
            ]);

            $response = $response->json();

            if (isset($response['key']['fromMe']) && $response['key']['fromMe'] === true)
                return true;

            return false;
        } catch (\Throwable) {
        }
    }
}
