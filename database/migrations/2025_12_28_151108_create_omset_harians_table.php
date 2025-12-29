<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('omset_harians', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('warung_id');
            $table->date('tanggal');

            $table->decimal('omset', 15, 2)->default(0);
            $table->decimal('profit', 15, 2)->default(0);
            $table->decimal('owner_profit', 15, 2)->default(0);
            $table->decimal('penjaga_profit', 15, 2)->default(0);

            $table->timestamps();

            $table->unique(['warung_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('omset_harians');
    }
};
