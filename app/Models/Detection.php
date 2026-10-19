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
        'land_class_id',
        'land_class_label',
        'tipe',
        'cluster_id',
    ];

    protected $casts = [
        'confidence' => 'decimal:2',
        'lokasi_lat' => 'decimal:7',
        'lokasi_lng' => 'decimal:7',
        'land_class_id' => 'integer',
        'cluster_id' => 'integer',
    ];

    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }
}
