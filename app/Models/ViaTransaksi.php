<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ViaTransaksi extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'via_id');
    }
}
