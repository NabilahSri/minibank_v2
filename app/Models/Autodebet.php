<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Autodebet extends Model
{
    use HasUuids, \Spatie\Activitylog\Traits\LogsActivity;

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Autodebet has been {$eventName}");
    }

    public function tapActivity(\Spatie\Activitylog\Models\Activity $activity, string $eventName)
    {
        $activity->properties = $activity->properties->merge([
            'ip' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
        ]);
    }

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
        'tgl_penarikan' => 'integer',
    ];

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
