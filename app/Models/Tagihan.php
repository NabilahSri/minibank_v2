<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'is_tagihan_aktif' => 'boolean',
        'tanggal' => 'date',
        'waktu_berlaku' => 'datetime',
        'waktu_berakhir' => 'datetime',
        'total_nilai_tagihan' => 'decimal:2',
    ];
}
