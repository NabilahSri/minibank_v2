<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BpiService
{
    /**
     * Get OAuth2 Bearer Token from Keycloak (with 50-minute cache)
     */
    public function getToken(): ?string
    {
        return Cache::remember('bpi_access_token', 3000, function () {
            try {
                $response = Http::asForm()->post(config('bpi.token_url'), [
                    'client_id' => config('bpi.client_id'),
                    'grant_type' => config('bpi.grant_type'),
                    'username' => config('bpi.username'),
                    'password' => config('bpi.password'),
                    'client_secret' => config('bpi.client_secret'),
                ]);

                if ($response->successful()) {
                    return $response->json('access_token');
                }

                Log::error('BPI OAuth Token Error', ['body' => $response->body()]);
                return null;
            } catch (\Throwable $e) {
                Log::error('BPI OAuth Connection Error: ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Clear cached OAuth Token
     */
    public function forgetToken(): void
    {
        Cache::forget('bpi_access_token');
    }

    /**
     * Register a new Virtual Account / Tagihan to BPI MAKA
     */
    public function registerVa(array $payload): array
    {
        $token = $this->getToken();
        if (!$token) {
            return ['code' => '99', 'message' => 'Gagal mendapatkan akses token BPI MAKA'];
        }

        $url = rtrim(config('bpi.base_url'), '/') . '/register';

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->contentType('application/json')
                ->post($url, $payload);

            if ($response->status() === 401) {
                // Token expired, retry once with fresh token
                $this->forgetToken();
                $token = $this->getToken();
                $response = Http::withToken($token)
                    ->acceptJson()
                    ->contentType('application/json')
                    ->post($url, $payload);
            }

            return $response->json() ?? [
                'code' => (string) $response->status(),
                'message' => $response->body()
            ];
        } catch (\Throwable $e) {
            Log::error('BPI Register VA Error: ' . $e->getMessage());
            return ['code' => '99', 'message' => 'Gagal terhubung ke server BPI BSI: ' . $e->getMessage()];
        }
    }

    /**
     * Cancel Virtual Account / Tagihan on BPI MAKA
     */
    public function cancelVa(array $payload): array
    {
        $token = $this->getToken();
        if (!$token) {
            return ['code' => '99', 'message' => 'Gagal mendapatkan akses token BPI MAKA'];
        }

        $url = rtrim(config('bpi.base_url'), '/') . '/cancel';

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->contentType('application/json')
                ->post($url, $payload);

            return $response->json() ?? [
                'code' => (string) $response->status(),
                'message' => $response->body()
            ];
        } catch (\Throwable $e) {
            Log::error('BPI Cancel VA Error: ' . $e->getMessage());
            return ['code' => '99', 'message' => 'Gagal terhubung ke server BPI BSI'];
        }
    }

    /**
     * Inquiry Virtual Account / Tagihan on BPI MAKA
     */
    public function inquiryVa(array $payload): array
    {
        $token = $this->getToken();
        if (!$token) {
            return ['code' => '99', 'message' => 'Gagal mendapatkan akses token BPI MAKA'];
        }

        $url = rtrim(config('bpi.base_url'), '/') . '/inquiry';

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->contentType('application/json')
                ->post($url, $payload);

            return $response->json() ?? [
                'code' => (string) $response->status(),
                'message' => $response->body()
            ];
        } catch (\Throwable $e) {
            Log::error('BPI Inquiry VA Error: ' . $e->getMessage());
            return ['code' => '99', 'message' => 'Gagal terhubung ke server BPI BSI'];
        }
    }
}
