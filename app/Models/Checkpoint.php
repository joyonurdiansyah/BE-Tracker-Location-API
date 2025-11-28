<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkpoint extends Model
{

    use HasFactory;
    protected $fillable = [
        'nama_titik',
        'kode_qr',
        'lokasi',
        'deskripsi',
    ];
    
    public function logs()
    {
        return $this->hasMany(CheckpointLog::class);
    }
}
