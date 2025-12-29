<?php

namespace App\Console\Commands;

use App\Services\WhatsAppService;
use Illuminate\Console\Command;

class SendTestAlertCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test-alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test omset alert via WhatsApp';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $whatsappService): int
    {
        $this->info('Sending test omset alert...');
        $this->newLine();

        // Data dummy untuk testing
        $omsetHariIni = 1_000_000;
        $avgOmset7Hari = 2_000_000;
        $persentaseTurun = 50;

        $result = $whatsappService->sendOmsetAlert(
            $omsetHariIni,
            $avgOmset7Hari,
            $persentaseTurun
        );

        if ($result['success']) {
            $this->info('✅ Test alert sent successfully!');
            $this->info('Response: ' . json_encode($result['data'], JSON_PRETTY_PRINT));
        } else {
            $this->error('❌ Failed to send test alert!');
            $this->error('Error: ' . ($result['error'] ?? 'Unknown error'));
        }

        return $result['success'] ? Command::SUCCESS : Command::FAILURE;
    }
}

