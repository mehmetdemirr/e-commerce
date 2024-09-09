<?php

namespace App\Enum;

enum PaymentStatusEnum
{
    public const PENDING = 'Pending';
    public const PAID = 'Paid';
    public const FAILED = 'Failed';
    public const REFUNDED = 'Refunded';

    public static function getStatuses(): array
    {
        return [
            self::PENDING,
            self::PAID,
            self::FAILED,
            self::REFUNDED,
        ];
    }
}
