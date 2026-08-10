<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Due extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'month_year',
        'amount',
        'status',
        'payment_date',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the due.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for unpaid dues.
     */
    public function scopeUnpaid(Builder $query): Builder
    {
        return $query->where('status', 'unpaid');
    }

    /**
     * Scope for paid dues.
     */
    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', 'paid');
    }
}
