<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warung extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nama',
        'alamat',
        'owner_id',
        'persentase_owner',
        'persentase_penjaga',
        'deskripsi',
        'no_hp',
        'catatan',
    ];

    public function omsetHarians()
    {
        return $this->hasMany(OmsetHarian::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function penjagas()
    {
        return $this->hasMany(User::class, 'warung_id');
    }
}
