<?php

namespace App\Enum;

enum PaymentStatusEnum : string
{
    public const PENDING = 'pending';
    public const PAID = 'paid';
    public const FAILED = 'failed';
    public const REFUNDED = 'refunded';

    public static function getStatuses(): array
    {
        return [
            self::PENDING,
            self::PAID,
            self::FAILED,
            self::REFUNDED,
        ];
    }

    private static array $statusTransitions = [
        self::PENDING => [self::FAILED, self::PAID],
        self::FAILED => [self::PENDING, self::PAID],
        self::PAID => [],
        self::REFUNDED => [],
    ];

    public static function fromString(string $status): self
    {
        $statuses = array_flip(self::getStatuses());

        if (!array_key_exists($status, $statuses)) {
            throw new \InvalidArgumentException("Invalid status value: $status");
        }

        return self::from($statuses[$status]);
    }

    public static function canUpdateStatus(PaymentStatusEnum $currentStatus, PaymentStatusEnum $newStatus): bool
    {
        return in_array($newStatus->value, self::$statusTransitions[$currentStatus->value], true);
    }

}
