<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lokasi extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }
}
