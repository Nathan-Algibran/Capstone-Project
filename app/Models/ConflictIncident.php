<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConflictIncident extends Model
{
    protected $fillable = [
        'species_id',
        'lokasi_lat',
        'lokasi_lng',
        'lokasi_nama',
        'tanggal',
        'sumber',
        'deskripsi',
    ];

    protected $casts = [
        'lokasi_lat' => 'decimal:7',
        'lokasi_lng' => 'decimal:7',
        'tanggal' => 'date',
    ];

    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }
}
