<?php
/**
 * Migration Helper for Shared Hosting (InfinityFree)
 * 
 * CARA PAKAI:
 * 1. Upload file ini ke root folder (htdocs)
 * 2. Buka via browser: https://your-domain.com/migrate.php
 * 3. Tunggu sampai selesai
 * 4. HAPUS file ini setelah selesai (PENTING untuk keamanan!)
 * 
 * PERINGATAN:
 * - File ini akan menjalankan migrate:fresh (hapus semua data!)
 * - Pastikan backup database sebelum menjalankan
 * - Hapus file ini setelah selesai
 */

// Cek apakah sudah di production
if (!file_exists(__DIR__.'/vendor/autoload.php')) {
    die('Error: vendor/autoload.php not found. Run "composer install" first.');
}

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<h1>🚀 Running Database Migration</h1>";
echo "<p>Please wait...</p>";
echo "<pre>";

try {
    // Run migrate:fresh --seed
    $status = $kernel->handle(
        $input = new Symfony\Component\Console\Input\ArrayInput([
            'command' => 'migrate:fresh',
            '--seed' => true,
            '--force' => true,
        ]),
        new Symfony\Component\Console\Output\ConsoleOutput
    );

    echo "\n\n";
    echo "✅ Migration completed successfully!\n";
    echo "Status code: " . $status . "\n\n";
    
    echo "📊 Database seeded with dummy data:\n";
    echo "- 1 Owner account\n";
    echo "- 3 Penjaga accounts\n";
    echo "- 3 Warung\n";
    echo "- 90 days of omset data\n\n";
    
    echo "🔐 Login Credentials:\n";
    echo "Owner:\n";
    echo "  Email: owner@warung.com\n";
    echo "  Password: password\n\n";
    echo "Penjaga:\n";
    echo "  Email: penjaga1@warung.com\n";
    echo "  Password: password\n\n";
    
    echo "⚠️ IMPORTANT: DELETE THIS FILE NOW!\n";
    echo "For security reasons, please delete migrate.php from your server.\n";

    $kernel->terminate($input, $status);
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n";
    echo $e->getTraceAsString();
}

echo "</pre>";

echo "<hr>";
echo "<p><strong>⚠️ PERINGATAN KEAMANAN:</strong></p>";
echo "<p style='color: red; font-weight: bold;'>HAPUS FILE INI SEKARANG! File ini berbahaya jika dibiarkan di server.</p>";
echo "<p>Cara hapus: Login ke File Manager → Hapus file 'migrate.php'</p>";

