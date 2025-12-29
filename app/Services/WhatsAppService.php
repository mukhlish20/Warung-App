<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $apiUrl;
    protected string $apiKey;
    protected string $phoneNumber;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.api_url');
        $this->apiKey = config('services.whatsapp.api_key');
        $this->phoneNumber = config('services.whatsapp.phone_number');
    }

    /**
     * Kirim pesan WhatsApp
     * Support: Fonnte.com & Custom Server
     *
     * @param string $to Nomor tujuan (format: 628xxx)
     * @param string $message Isi pesan
     * @return array
     */
    public function sendMessage(string $to, string $message): array
    {
        try {
            // Deteksi provider berdasarkan URL
            if (str_contains($this->apiUrl, 'fonnte.com')) {
                return $this->sendViaFonnte($to, $message);
            }

            // Fallback ke custom server
            return $this->sendViaCustomServer($to, $message);

        } catch (\Exception $e) {
            Log::error('WhatsApp exception', [
                'to' => $to,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Kirim via Fonnte.com
     */
    protected function sendViaFonnte(string $to, string $message): array
    {
        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => $this->apiKey, // Fonnte tidak pakai "Bearer"
            ])
            ->post($this->apiUrl, [
                'target' => $to,
                'message' => $message,
                'countryCode' => '62',
            ]);

        if ($response->successful()) {
            $data = $response->json();

            Log::info('WhatsApp sent via Fonnte', [
                'to' => $to,
                'response' => $data,
            ]);

            // Fonnte return format: {"status": true, "message": "..."}
            return [
                'success' => $data['status'] ?? false,
                'data' => $data,
            ];
        }

        Log::error('Fonnte send failed', [
            'to' => $to,
            'status' => $response->status(),
            'response' => $response->body(),
        ]);

        return [
            'success' => false,
            'error' => $response->body(),
        ];
    }

    /**
     * Kirim via Custom Server (whatsapp-web.js / Baileys)
     */
    protected function sendViaCustomServer(string $to, string $message): array
    {
        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post($this->apiUrl . '/send-message', [
                'phone' => $to,
                'message' => $message,
            ]);

        if ($response->successful()) {
            Log::info('WhatsApp sent successfully', [
                'to' => $to,
                'response' => $response->json(),
            ]);

            return [
                'success' => true,
                'data' => $response->json(),
            ];
        }

        Log::error('WhatsApp send failed', [
            'to' => $to,
            'status' => $response->status(),
            'response' => $response->body(),
        ]);

        return [
            'success' => false,
            'error' => $response->body(),
        ];
    }

    /**
     * Kirim alert omset turun
     *
     * @param float $omsetHariIni
     * @param float $avgOmset7Hari
     * @param float $persentaseTurun
     * @return array
     */
    public function sendOmsetAlert(float $omsetHariIni, float $avgOmset7Hari, float $persentaseTurun): array
    {
        $message = $this->formatOmsetAlert($omsetHariIni, $avgOmset7Hari, $persentaseTurun);
        
        return $this->sendMessage($this->phoneNumber, $message);
    }

    /**
     * Format pesan alert omset turun
     */
    protected function formatOmsetAlert(float $omsetHariIni, float $avgOmset7Hari, float $persentaseTurun): string
    {
        $tanggal = now()->format('d/m/Y');
        $waktu = now()->format('H:i');

        return "🚨 *ALERT OMSET TURUN* 🚨\n\n"
            . "📅 Tanggal: {$tanggal}\n"
            . "🕐 Waktu: {$waktu}\n\n"
            . "⚠️ Omset hari ini turun *{$persentaseTurun}%*\n\n"
            . "📊 *Detail:*\n"
            . "• Omset Hari Ini: " . $this->formatRupiah($omsetHariIni) . "\n"
            . "• Rata-rata 7 Hari: " . $this->formatRupiah($avgOmset7Hari) . "\n"
            . "• Selisih: " . $this->formatRupiah($avgOmset7Hari - $omsetHariIni) . "\n\n"
            . "💡 Mohon segera dicek kondisi warung.\n\n"
            . "_Warung App - Automated Alert_";
    }

    /**
     * Format rupiah untuk WhatsApp
     */
    protected function formatRupiah(float $amount): string
    {
        if ($amount >= 1_000_000_000) {
            return 'Rp ' . number_format($amount / 1_000_000_000, 1) . ' M';
        }
        if ($amount >= 1_000_000) {
            return 'Rp ' . number_format($amount / 1_000_000, 1) . ' jt';
        }
        if ($amount >= 1_000) {
            return 'Rp ' . number_format($amount / 1_000, 1) . ' rb';
        }
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    /**
     * Test koneksi WhatsApp API
     */
    public function testConnection(): array
    {
        $message = "✅ Test koneksi WhatsApp API berhasil!\n\n"
            . "Waktu: " . now()->format('d/m/Y H:i:s') . "\n\n"
            . "_Warung App - Test Message_";

        return $this->sendMessage($this->phoneNumber, $message);
    }
}

