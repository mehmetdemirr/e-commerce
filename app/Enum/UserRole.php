<?php

namespace App\Enum;

enum UserRole : String 
{
    public const SUPERADMIN = 'super-admin';
    public const ADMIN = "admin";
    public const USER = 'user';
    public const COMPANY = 'company';
    public const CALLCENTER = 'call-center';
}
