<?php

namespace App\Enum;

enum OrderStatusEnum
{
    public const PENDING = 'Pending';
    public const CONFIRMED = 'Confirmed';
    public const SHIPPED = 'Shipped';
    public const DELIVERED = 'Delivered';
    public const RETURNED = 'Returned';
    public const CANCELED = 'Canceled';

    public static function getStatuses(): array
    {
        return [
            self::PENDING,
            self::CONFIRMED,
            self::SHIPPED,
            self::DELIVERED,
            self::RETURNED,
            self::CANCELED,
        ];
    }
}
