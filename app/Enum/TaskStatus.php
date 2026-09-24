<?php

namespace App\Enum;

enum TaskStatus: string
{
    CASE ONGOING = 'on-going';
    CASE COMPLETED = 'completed';
    CASE CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::ONGOING => 'On-Going',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::ONGOING => 'bg-warning',
            self::COMPLETED => 'bg-success',
            self::CANCELLED => 'bg-danger',
        };
    }
}
