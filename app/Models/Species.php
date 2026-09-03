<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Species extends Model
{
    protected $table = 'species';

    protected $fillable = [
        'nama_ilmiah',
        'nama_umum',
        'slug',
        'status_konservasi',
        'deskripsi',
        'habitat',
        'ancaman_utama',
        'foto_url',
        'jumlah_terdeteksi',
    ];

    protected $casts = [
        'jumlah_terdeteksi' => 'integer',
    ];

    public function detections(): HasMany
    {
        return $this->hasMany(Detection::class);
    }

    public function conflictIncidents(): HasMany
    {
        return $this->hasMany(ConflictIncident::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
