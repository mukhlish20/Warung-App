<?php

namespace App\Listeners;

use App\Events\OmsetTurunDetected;
use App\Models\OmsetAlert;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class SendWhatsAppAlert
{
    protected WhatsAppService $whatsappService;

    /**
     * Create the event listener.
     */
    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Handle the event.
     */
    public function handle(OmsetTurunDetected $event): void
    {
        // Cek apakah sudah pernah kirim alert hari ini
        $existingAlert = OmsetAlert::whereDate('tanggal', now())
            ->where('whatsapp_sent', true)
            ->first();

        if ($existingAlert) {
            Log::info('WhatsApp alert already sent today');
            return;
        }

        // Kirim WhatsApp
        $result = $this->whatsappService->sendOmsetAlert(
            $event->omsetHariIni,
            $event->avgOmset7Hari,
            $event->persentaseTurun
        );

        // Simpan log alert
        OmsetAlert::create([
            'tanggal' => now()->toDateString(),
            'omset_hari_ini' => $event->omsetHariIni,
            'avg_7_hari' => $event->avgOmset7Hari,
            'persentase_turun' => $event->persentaseTurun,
            'whatsapp_sent' => $result['success'],
            'whatsapp_response' => json_encode($result),
            'sent_at' => $result['success'] ? now() : null,
        ]);

        if ($result['success']) {
            Log::info('WhatsApp alert sent successfully', [
                'omset_hari_ini' => $event->omsetHariIni,
                'persentase_turun' => $event->persentaseTurun,
            ]);
        } else {
            Log::error('Failed to send WhatsApp alert', [
                'error' => $result['error'] ?? 'Unknown error',
            ]);
        }
    }
}

