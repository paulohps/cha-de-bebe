<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Number extends Model
{
    use HasFactory;

    protected $fillable = [
        'approved_id',
        'diaper_id',
        'value',
        'name',
        'phone',
        'approved_at',
        'observations',
        'expired_at'
    ];

    protected $dates = [
        'approved_at',
        'expired_at'
    ];

    public function diaper(): BelongsTo
    {
        return $this->belongsTo(Diaper::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_id');
    }

    public function approve(string $name, string $phone): void
    {
        if ($this->isExpired() || $this->isApproved()) {
            return;
        }

        $this->update([
            'name' => $name,
            'phone' => $phone,
            'approved_at' => now(),
            'expired_at' => null,
            'approved_id' => auth()->id()
        ]);
    }

    public function disapprove(): void
    {
        if (!$this->isApproved()) {
            return;
        }

        $this->update([
            'approved_id' => null,
            'approved_at' => null,
            'expired_at' => self::makeExpiredAt()
        ]);
    }

    public function reset(): void
    {
        $this->update([
            'name' => null,
            'phone' => null,
            'approved_at' => null,
            'expired_at' => null,
            'approved_id' => null
        ]);
    }

    public function isApproved(): bool
    {
        return $this->approved_at !== null;
    }

    public function isExpired(): bool
    {
        return $this->expired_at !== null && $this->expired_at->lessThan(now());
    }

    public function itHasAnOwner(): bool
    {
        return $this->name && $this->phone;
    }

    public function isReserved(): bool
    {
        return (!$this->expired_at || $this->expired_at->greaterThan(now()))
            && ($this->name || $this->phone);
    }

    public static function makeExpiredAt(): Carbon
    {
        return now()->addMinutes(config('numbers.expire_at_minutes'));
    }
}
