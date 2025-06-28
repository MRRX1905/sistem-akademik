<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataKuliah extends Model
{
    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
        'semester',
        'program_studi',
        'deskripsi',
        'status',
    ];

    /**
     * Get the KRS records for the mata kuliah.
     */
    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class);
    }

    /**
     * Get the nilai records for the mata kuliah.
     */
    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }
}
