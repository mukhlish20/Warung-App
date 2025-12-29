<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warung extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nama_warung',
        'alamat',
        'no_hp',
        'catatan',
    ];

    public function omsetHarians()
    {
        return $this->hasMany(OmsetHarian::class);
    }
}
