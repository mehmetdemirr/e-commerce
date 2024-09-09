<?php

namespace App\Enum;

enum UserRole : String 
{
    case SUPERADMIN = 'super-admin';
    case ADMIN = "admin";
    case USER = 'user';
    case COMPANY = 'company';
    case CALLCENTER = 'call-center';
}
