<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutodebetLog extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'nominal' => 'decimal:2',
    ];

    public function autodebet(): BelongsTo
    {
        return $this->belongsTo(Autodebet::class);
    }

    public function rekeningAsal(): BelongsTo
    {
        return $this->belongsTo(Rekening::class, 'rekening_id');
    }

    public function rekeningTujuan(): BelongsTo
    {
        return $this->belongsTo(Rekening::class, 'rekening_tujuan_id');
    }

    public function subrekening(): BelongsTo
    {
        return $this->belongsTo(Subrekening::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
