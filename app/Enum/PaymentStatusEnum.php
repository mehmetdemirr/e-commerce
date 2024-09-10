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

    public static function fromString(string $status): self
    {
        $statuses = array_flip(self::getStatuses());

        if (!array_key_exists($status, $statuses)) {
            throw new \InvalidArgumentException("Invalid status value: $status");
        }

        return self::from($statuses[$status]);
    }

    public static function canUpdateStatus(self $currentStatus, self $newStatus): bool
    {
        return in_array($newStatus->value, self::getAllowedTransitions($currentStatus->value), true);
    }

    private static function getAllowedTransitions(string $currentStatus): array
    {
        $transitions = [
            self::PENDING => [self::PAID, self::FAILED],
            self::PAID => [self::REFUNDED],
            self::FAILED => [self::PAID],
            self::REFUNDED => [],
        ];

        return $transitions[$currentStatus] ?? [];
    }

}
