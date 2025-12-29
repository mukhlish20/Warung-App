<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('warungs', function (Blueprint $table) {
            $table->string('alamat')->nullable()->after('nama_warung');
            $table->string('no_hp')->nullable()->after('alamat');
            $table->text('catatan')->nullable()->after('no_hp');
        });
    }

    public function down(): void
    {
        Schema::table('warungs', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'no_hp', 'catatan']);
        });
    }
};
