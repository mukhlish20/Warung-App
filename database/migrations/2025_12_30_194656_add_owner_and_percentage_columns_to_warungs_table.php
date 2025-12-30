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
        Schema::table('warungs', function (Blueprint $table) {
            $table->renameColumn('nama_warung', 'nama');
            $table->unsignedBigInteger('owner_id')->nullable()->after('nama');
            $table->decimal('persentase_owner', 5, 2)->default(50)->after('owner_id');
            $table->decimal('persentase_penjaga', 5, 2)->default(50)->after('persentase_owner');
            $table->text('deskripsi')->nullable()->after('persentase_penjaga');
            
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warungs', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropColumn(['owner_id', 'persentase_owner', 'persentase_penjaga', 'deskripsi']);
            $table->renameColumn('nama', 'nama_warung');
        });
    }
};
