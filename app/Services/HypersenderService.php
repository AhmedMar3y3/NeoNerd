<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class HypersenderService
{
    public static function sendMessage($phone, $message)
    {
        try {
            $apiKey   = env('HYPERSENDER_API_KEY');
            $deviceId = env('HYPERSENDER_INSTANCE_ID');
            $baseUrl  = env('HYPERSENDER_BASEURL');

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
            ])->post("{$baseUrl}/{$deviceId}/send-text-safe", [
                "chatId" => "{$phone}@c.us",
                "text"         => $message,
                "reply_to"     => "string",
                "link_preview" => false,
            ]);

            $response = $response->json();

            if (isset($response['_data']['Info']['IsFromMe']) && $response['_data']['Info']['IsFromMe'] === true) {
                return true;
            }

            return false;
        } catch (\Throwable $e) {
            \Log::error('Hypersender error: ' . $e->getMessage());
        }
    }
}
