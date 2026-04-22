<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMIN = "admin";
    case SISWA = "siswa";

    public static function getAllRoles(): array
    {
        return array_column(self::cases(), 'value');
    }
}
