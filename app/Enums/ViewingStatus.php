<?php

namespace App\Enums;

enum ViewingStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Na čekanju',
            self::Confirmed => 'Potvrđeno',
            self::Cancelled => 'Otkazano',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'text-bg-warning',
            self::Confirmed => 'text-bg-success',
            self::Cancelled => 'text-bg-danger',
        };
    }
}
