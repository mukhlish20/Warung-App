<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmsetHarian extends Model
{
    protected $fillable = [
        'warung_id',
        'penjaga_id',
        'tanggal',
        'omset',
        'bagian_owner',
        'bagian_penjaga',
        'catatan',
    ];

    public function warung()
    {
        return $this->belongsTo(Warung::class);
    }

    public function penjaga()
    {
        return $this->belongsTo(User::class, 'penjaga_id');
    }
}
