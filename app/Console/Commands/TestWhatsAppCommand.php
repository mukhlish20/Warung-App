<?php

namespace App\Console\Commands;

use App\Services\WhatsAppService;
use Illuminate\Console\Command;

class TestWhatsAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test WhatsApp API connection';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $whatsappService): int
    {
        $this->info('Testing WhatsApp API connection...');
        $this->newLine();

        $result = $whatsappService->testConnection();

        if ($result['success']) {
            $this->info('✅ WhatsApp API connection successful!');
            $this->info('Response: ' . json_encode($result['data'], JSON_PRETTY_PRINT));
        } else {
            $this->error('❌ WhatsApp API connection failed!');
            $this->error('Error: ' . ($result['error'] ?? 'Unknown error'));
        }

        return $result['success'] ? Command::SUCCESS : Command::FAILURE;
    }
}

