<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('warung_id')
                ->references('id')
                ->on('warungs')
                ->nullOnDelete();
        });

        Schema::table('omset_harians', function (Blueprint $table) {
            $table->foreign('warung_id')
                ->references('id')
                ->on('warungs')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['warung_id']);
        });

        Schema::table('omset_harians', function (Blueprint $table) {
            $table->dropForeign(['warung_id']);
        });
    }
};
