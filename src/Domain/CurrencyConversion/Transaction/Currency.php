<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction;

readonly class Currency
{
    public function __construct(private string $code)
    {
    }

    public function toString(): string
    {
        return $this->code;
    }

    public function equals(Currency $currency): bool
    {
        return $currency->toString() === $this->toString();
    }
}
