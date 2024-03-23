<?php

namespace App\Enum;

enum UserEnum: string
{
    case ROLE_ADMIN = 'ROLE_ADMIN';
    case ROLE_ACCOUNTANT = 'ROLE_ACCOUNTANT';
    case ROLE_USER = '';
}
