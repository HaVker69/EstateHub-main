<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Na čekanju',
            self::Approved => 'Odobreno',
            self::Rejected => 'Odbijeno',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'status-badge-pending',
            self::Approved => 'status-badge-approved',
            self::Rejected => 'status-badge-rejected',
        };
    }
}
