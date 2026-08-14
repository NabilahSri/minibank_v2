<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subrekening extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = ['nominal' => 'decimal:2'];

    public function rekening(): BelongsTo
    {
        return $this->belongsTo(Rekening::class);
    }

    public function anggotaGroup(): BelongsToMany
    {
        return $this->belongsToMany(Rekening::class, 'group_pembayarans', 'subrekening_id', 'rekening_id')->using(GroupPembayaran::class)->withTimestamps();
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }

    public function autodebet(): HasMany
    {
        return $this->hasMany(Autodebet::class);
    }
}
