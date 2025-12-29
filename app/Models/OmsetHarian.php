<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmsetHarian extends Model
{
    protected $fillable = [
        'warung_id',
        'tanggal',
        'omset',
        'profit',
        'owner_profit',
        'penjaga_profit',
    ];

    public function warung()
    {
        return $this->belongsTo(Warung::class);
    }
}
