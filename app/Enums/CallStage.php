<?php

namespace App\Enums;

enum CallStage: string
{
    case Archived = 'Archived';
    case Completed = 'Completed';
    case Draft = 'Draft';
    case InProgress = 'In Progress';
    case Open = 'Open';

    public static function excluded(): array
    {
        return [
            self::Archived->value,
            self::Draft->value,
        ];
    }

    public static function active(): array
    {
        return [
            self::Completed->value,
            self::InProgress->value,
            self::Open->value,
        ];
    }
}