<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rekening extends Model
{
    use HasUuids, \Spatie\Activitylog\Traits\LogsActivity;

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Rekening has been {$eventName}");
    }

    public function tapActivity(\Spatie\Activitylog\Models\Activity $activity, string $eventName)
    {
        $activity->properties = $activity->properties->merge([
            'ip' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
        ]);
    }

    protected $guarded = [];

    protected $hidden = ['pin'];

    protected $casts = ['status' => 'boolean'];

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subrekening(): HasMany
    {
        return $this->hasMany(Subrekening::class);
    }

    public function groupSubrekening(): BelongsToMany
    {
        return $this->belongsToMany(Subrekening::class, 'group_pembayarans', 'rekening_id', 'subrekening_id')->using(GroupPembayaran::class)->withTimestamps();
    }

    public function transaksiAsal(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'rekening_id');
    }

    public function transaksiTujuan(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'rekening_tujuan_id');
    }

    public function getSaldoAttribute(): float
    {
        // Setoran (where rekening_id = $this->id and sandi.jenis_transaksi = 'setor')
        $totalSetor = Transaksi::where('rekening_id', $this->id)
            ->whereHas('sandi', function ($q) {
                $q->where('jenis_transaksi', 'setor');
            })
            ->sum('nominal');

        // Penarikan (where rekening_id = $this->id and sandi.jenis_transaksi = 'tarik')
        $totalTarik = Transaksi::where('rekening_id', $this->id)
            ->whereHas('sandi', function ($q) {
                $q->where('jenis_transaksi', 'tarik');
            })
            ->sum('nominal');

        // Transfer keluar (where rekening_id = $this->id and sandi.jenis_transaksi = 'transfer')
        $totalTransferKeluar = Transaksi::where('rekening_id', $this->id)
            ->whereHas('sandi', function ($q) {
                $q->where('jenis_transaksi', 'transfer');
            })
            ->sum('nominal');

        // Transfer masuk (where rekening_tujuan_id = $this->id and sandi.jenis_transaksi = 'transfer')
        $totalTransferMasuk = Transaksi::where('rekening_tujuan_id', $this->id)
            ->whereHas('sandi', function ($q) {
                $q->where('jenis_transaksi', 'transfer');
            })
            ->sum('nominal');

        return (float) ($totalSetor + $totalTransferMasuk - $totalTarik - $totalTransferKeluar);
    }

    public function autodebetAsal(): HasMany
    {
        return $this->hasMany(Autodebet::class, 'rekening_id');
    }

    public function autodebetTujuan(): HasMany
    {
        return $this->hasMany(Autodebet::class, 'rekening_tujuan_id');
    }
}
