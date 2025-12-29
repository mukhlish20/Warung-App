<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('omset_alerts', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->decimal('omset_hari_ini', 15, 2);
            $table->decimal('avg_7_hari', 15, 2);
            $table->decimal('persentase_turun', 5, 2);
            $table->boolean('whatsapp_sent')->default(false);
            $table->text('whatsapp_response')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('omset_alerts');
    }
};

