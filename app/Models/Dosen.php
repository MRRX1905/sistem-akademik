<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'bidang_keahlian',
        'pendidikan_terakhir',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the user that owns the dosen.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the KRS records for the dosen.
     */
    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class);
    }

    /**
     * Get the nilai records for the dosen.
     */
    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }
}
