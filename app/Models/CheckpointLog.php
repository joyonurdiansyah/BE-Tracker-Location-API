<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckpointLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkpoint_id',
        'user_id',
        'scanned_at',
        'keterangan',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function checkpoint()
    {
        return $this->belongsTo(Checkpoint::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
