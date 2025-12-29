<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\OmsetAlert;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class WhatsAppSettingController extends Controller
{
    /**
     * Tampilkan halaman setting WhatsApp
     */
    public function index()
    {
        $alerts = OmsetAlert::orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('owner.whatsapp-setting', [
            'alerts' => $alerts,
            'apiUrl' => config('services.whatsapp.api_url'),
            'phoneNumber' => config('services.whatsapp.phone_number'),
        ]);
    }

    /**
     * Test koneksi WhatsApp
     */
    public function testConnection(WhatsAppService $whatsappService)
    {
        $result = $whatsappService->testConnection();

        if ($result['success']) {
            return back()->with('success', '✅ Koneksi WhatsApp berhasil! Pesan test telah dikirim.');
        }

        return back()->with('error', '❌ Koneksi WhatsApp gagal: ' . ($result['error'] ?? 'Unknown error'));
    }

    /**
     * Kirim test alert
     */
    public function sendTestAlert(WhatsAppService $whatsappService)
    {
        $result = $whatsappService->sendOmsetAlert(
            1_000_000,  // Omset hari ini
            2_000_000,  // Avg 7 hari
            50          // Persentase turun
        );

        if ($result['success']) {
            return back()->with('success', '✅ Test alert berhasil dikirim!');
        }

        return back()->with('error', '❌ Gagal mengirim test alert: ' . ($result['error'] ?? 'Unknown error'));
    }
}

