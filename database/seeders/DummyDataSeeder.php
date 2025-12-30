<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Warung;
use App\Models\OmsetHarian;
use App\Models\OmsetAlert;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Membuat data dummy...');

        // 1. BUAT OWNER (atau ambil yang sudah ada)
        $this->command->info('👤 Membuat Owner...');

        $owner = User::firstOrCreate(
            ['email' => 'owner@warung.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'warung_id' => null,
            ]
        );

        $this->command->info("✅ Owner: {$owner->email} / password");

        // 2. BUAT WARUNG (3 CABANG) - atau ambil yang sudah ada
        $this->command->info('🏪 Membuat Warung...');

        $warungs = [
            [
                'nama' => 'Warung Maju Jaya - Cabang Pusat',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'owner_id' => $owner->id,
                'persentase_owner' => 50,
                'persentase_penjaga' => 50,
            ],
            [
                'nama' => 'Warung Maju Jaya - Cabang Timur',
                'alamat' => 'Jl. Ahmad Yani No. 45, Jakarta Timur',
                'owner_id' => $owner->id,
                'persentase_owner' => 50,
                'persentase_penjaga' => 50,
            ],
            [
                'nama' => 'Warung Maju Jaya - Cabang Selatan',
                'alamat' => 'Jl. Fatmawati No. 78, Jakarta Selatan',
                'owner_id' => $owner->id,
                'persentase_owner' => 50,
                'persentase_penjaga' => 50,
            ],
        ];

        $warungModels = [];
        foreach ($warungs as $warungData) {
            $warung = Warung::firstOrCreate(
                ['nama' => $warungData['nama']],
                $warungData
            );
            $warungModels[] = $warung;
            $this->command->info("✅ Warung: {$warung->nama}");
        }

        // 3. BUAT PENJAGA (1 per warung) - atau ambil yang sudah ada
        $this->command->info('👥 Membuat Penjaga...');

        $penjagaNames = ['Andi Wijaya', 'Siti Nurhaliza', 'Joko Susilo'];

        foreach ($warungModels as $index => $warung) {
            $email = 'penjaga' . ($index + 1) . '@warung.com';

            $penjaga = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $penjagaNames[$index],
                    'password' => Hash::make('password'),
                    'role' => 'penjaga',
                    'warung_id' => $warung->id,
                ]
            );

            $this->command->info("✅ Penjaga: {$penjaga->email} / password (Warung: {$warung->nama})");
        }

        // 4. BUAT OMSET HARIAN (30 HARI TERAKHIR)
        $this->command->info('💰 Membuat Omset Harian (30 hari)...');

        foreach ($warungModels as $warung) {
            $this->createOmsetData($warung);
        }

        // 5. BUAT OMSET ALERT (BEBERAPA RIWAYAT)
        $this->command->info('📱 Membuat Omset Alert...');
        
        $this->createAlertData();

        $this->command->info('');
        $this->command->info('🎉 ========================================');
        $this->command->info('✅ DATA DUMMY BERHASIL DIBUAT!');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('📋 LOGIN CREDENTIALS:');
        $this->command->info('');
        $this->command->info('👤 OWNER:');
        $this->command->info('   Email: owner@warung.com');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('👥 PENJAGA:');
        $this->command->info('   Email: penjaga1@warung.com / password (Cabang Pusat)');
        $this->command->info('   Email: penjaga2@warung.com / password (Cabang Timur)');
        $this->command->info('   Email: penjaga3@warung.com / password (Cabang Selatan)');
        $this->command->info('');
        $this->command->info('🏪 WARUNG: 3 cabang');
        $this->command->info('💰 OMSET: 30 hari terakhir per cabang');
        $this->command->info('📱 ALERT: Beberapa riwayat alert');
        $this->command->info('========================================');
    }

    /**
     * Buat data omset untuk 30 hari terakhir
     */
    protected function createOmsetData(Warung $warung): void
    {
        $baseOmset = rand(1500000, 2500000); // Base omset 1.5jt - 2.5jt

        for ($i = 29; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);
            
            // Variasi omset: ±30%
            $variation = rand(-30, 30) / 100;
            $omset = $baseOmset + ($baseOmset * $variation);
            
            // Buat omset turun drastis di beberapa hari (untuk simulasi alert)
            if (in_array($i, [5, 12, 20])) {
                $omset = $baseOmset * 0.6; // Turun 40%
            }

            // Hitung profit (10% dari omset, dibagi sesuai persentase warung)
            $profit = $omset * 0.1;
            $bagianOwner = $profit * ($warung->persentase_owner / 100);
            $bagianPenjaga = $profit * ($warung->persentase_penjaga / 100);

            // Ambil penjaga yang ditugaskan di warung ini
            $penjaga = User::where('warung_id', $warung->id)->where('role', 'penjaga')->first();

            OmsetHarian::create([
                'warung_id' => $warung->id,
                'tanggal' => $tanggal->toDateString(),
                'omset' => $omset,
                'owner_profit' => $bagianOwner,
                'penjaga_profit' => $bagianPenjaga,
            ]);
        }

        $this->command->info("✅ Omset created for: {$warung->nama} (30 hari)");
    }

    /**
     * Buat data alert dummy
     */
    protected function createAlertData(): void
    {
        $alerts = [
            [
                'tanggal' => Carbon::now()->subDays(20),
                'omset_hari_ini' => 1200000,
                'avg_7_hari' => 2000000,
                'persentase_turun' => 40,
                'whatsapp_sent' => true,
                'sent_at' => Carbon::now()->subDays(20)->setTime(15, 30),
            ],
            [
                'tanggal' => Carbon::now()->subDays(12),
                'omset_hari_ini' => 1300000,
                'avg_7_hari' => 2100000,
                'persentase_turun' => 38,
                'whatsapp_sent' => true,
                'sent_at' => Carbon::now()->subDays(12)->setTime(16, 15),
            ],
            [
                'tanggal' => Carbon::now()->subDays(5),
                'omset_hari_ini' => 1100000,
                'avg_7_hari' => 1900000,
                'persentase_turun' => 42,
                'whatsapp_sent' => true,
                'sent_at' => Carbon::now()->subDays(5)->setTime(14, 45),
            ],
        ];

        foreach ($alerts as $alertData) {
            $alertData['whatsapp_response'] = json_encode([
                'success' => true,
                'status' => true,
                'detail' => 'success! message in queue',
            ]);

            OmsetAlert::create($alertData);
        }

        $this->command->info("✅ Alert created: 3 riwayat alert");
    }
}

