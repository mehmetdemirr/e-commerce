<?php

namespace App\Enum;

enum OrderStatusEnum : string
{
    public const PENDING = 'pending';
    public const CONFIRMED = 'confirmed';
    public const SHIPPED = 'shipped';
    public const DELIVERED = 'delivered';
    public const RETURNED = 'returned';
    public const CANCELED = 'canceled';

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

    private static array $statusTransitions = [
        self::PENDING => [self::CONFIRMED],
        self::CONFIRMED => [self::SHIPPED],
        self::SHIPPED => [self::DELIVERED, self::RETURNED],
        self::DELIVERED => [self::RETURNED],
        self::RETURNED => [],
        self::CANCELED => []
    ];

    public static function fromString(string $status): self
    {
        $statuses = array_flip(self::getStatuses());

        if (!array_key_exists($status, $statuses)) {
            throw new \InvalidArgumentException("Invalid status value: $status");
        }

        return self::from($statuses[$status]);
    }

    public static function canUpdateStatus(OrderStatusEnum $currentStatus, OrderStatusEnum $newStatus): bool
    {
        if ($currentStatus === self::CANCELED || $currentStatus === self::RETURNED) {
            return false;
        }

        return in_array($newStatus, self::$statusTransitions[$currentStatus->value], true);
    }

}
