<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction;

readonly class Money
{

    public function __construct(private Amount $amountInMinorUnit, private Currency $currency)
    {
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getAmountInMinorUnit(): int
    {
        return $this->amountInMinorUnit->getValue();
    }

    public function add(Money $money): Money
    {
        if(!$money->currency->equals($this->currency)) {
            throw new \InvalidArgumentException('Cannot add Amounts in two different currencies');
        }

        return new Money(new Amount($this->getMinorUnitValue() + $money->getMinorUnitValue()), $this->currency);
    }

    public function subtract(Money $money): Money
    {
        if(!$money->currency->equals($this->currency)) {
            throw new \InvalidArgumentException('Cannot add Amounts in two different currencies');
        }

        return new Money(new Amount($this->getMinorUnitValue() - $money->getMinorUnitValue()), $this->currency);
    }

    private function getMinorUnitValue(): int
    {
        return $this->amountInMinorUnit->getValue();
    }

    public function equals(Money $money): bool
    {
        return $this->currency->equals($money->currency) && $this->amountInMinorUnit->equals($money->amountInMinorUnit);
    }
}
