<?php

namespace App\Models;

use App\Enums\PropertyStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Property extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_type_id',
        'title',
        'slug',
        'description',
        'price',
        'area',
        'rooms',
        'city',
        'address',
        'status',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'status' => PropertyStatus::class,
            'price' => 'decimal:2',
            'area' => 'decimal:2',
            'rooms' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Property $property) {
            if (blank($property->slug)) {
                $property->slug = Str::slug($property->title).'-'.Str::random(6);
            }

            if (blank($property->status)) {
                $property->status = PropertyStatus::Pending;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function viewings(): HasMany
    {
        return $this->hasMany(Viewing::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', PropertyStatus::Approved);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, fn (Builder $q, $search) => $q->where(function (Builder $q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            }))
            ->when($filters['type'] ?? null, fn (Builder $q, $type) => $q->where('property_type_id', $type))
            ->when($filters['city'] ?? null, fn (Builder $q, $city) => $q->where('city', 'like', "%{$city}%"))
            ->when($filters['min_price'] ?? null, fn (Builder $q, $min) => $q->where('price', '>=', $min))
            ->when($filters['max_price'] ?? null, fn (Builder $q, $max) => $q->where('price', '<=', $max))
            ->when($filters['min_area'] ?? null, fn (Builder $q, $min) => $q->where('area', '>=', $min))
            ->when($filters['max_area'] ?? null, fn (Builder $q, $max) => $q->where('area', '<=', $max))
            ->when($filters['rooms'] ?? null, fn (Builder $q, $rooms) => $q->where('rooms', '>=', $rooms));
    }

    public function isFavoritedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->favoritedBy()->where('users.id', $user->id)->exists();
    }
}
