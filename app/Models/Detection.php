<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detection extends Model
{
    protected $fillable = [
        'species_id',
        'foto_url',
        'confidence',
        'lokasi_lat',
        'lokasi_lng',
        'lokasi_nama',
    ];

    protected $casts = [
        'confidence' => 'decimal:2',
        'lokasi_lat' => 'decimal:7',
        'lokasi_lng' => 'decimal:7',
    ];

    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }
}
