<?php

namespace App\Models;

use App\Enums\ViewingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Viewing extends Model
{
    /** @use HasFactory<\Database\Factories\ViewingFactory> */
    use HasFactory;

    protected $fillable = [
        'property_id',
        'user_id',
        'scheduled_at',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'status' => ViewingStatus::class,
        ];
    }

    protected static function booted(): void
    {
        //model event hook
        static::creating(function (Viewing $viewing) {
            if (blank($viewing->status)) {
                $viewing->status = ViewingStatus::Pending;
            }
        });
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
