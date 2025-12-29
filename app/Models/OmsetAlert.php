<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmsetAlert extends Model
{
    protected $fillable = [
        'tanggal',
        'omset_hari_ini',
        'avg_7_hari',
        'persentase_turun',
        'whatsapp_sent',
        'whatsapp_response',
        'sent_at',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'omset_hari_ini' => 'decimal:2',
        'avg_7_hari' => 'decimal:2',
        'persentase_turun' => 'decimal:2',
        'whatsapp_sent' => 'boolean',
        'sent_at' => 'datetime',
    ];
}

