<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction;

readonly class Id
{

    public function __construct(private string $id)
    {
    }

    public function toString(): string
    {
        return $this->id;
    }
}
