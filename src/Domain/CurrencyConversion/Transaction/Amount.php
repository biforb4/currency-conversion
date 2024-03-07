<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction;

readonly class Amount
{
    public function __construct(private int $value)
    {
    }

    public static function fromFloat(float $value): Amount
    {
        return new Amount((int)round($value));
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(Amount $amount): bool
    {
        return $this->value === $amount->value;
    }
}
