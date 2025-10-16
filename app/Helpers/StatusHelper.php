<?php

namespace App\Helpers;

class StatusHelper
{
    public static function getStatusLabel($value)
    {
        return match ((string) $value) {
            '-1' => 'Not Complied',
            '0' => 'Partially Complied',
            '1' => 'Complied',
            default => 'Unknown',
        };
    }

    public static function statusOptions(): array
    {
        return [
            '-1' => 'Not Complied',
            '0'  => 'Partially Complied',
            '1'  => 'Complied',
        ];
    }

    public static function getStatusColor($value): string
    {
        return match ((string) $value) {
            '-1' => 'danger',   // red
            '0'  => 'warning',  // yellow/orange
            '1'  => 'success',  // green
            default => 'gray',  // neutral
        };
    }
}
