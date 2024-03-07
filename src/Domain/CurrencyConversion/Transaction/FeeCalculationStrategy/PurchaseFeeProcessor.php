<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\FeeCalculationStrategy;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Amount;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Money;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Type;
use Override;

class PurchaseFeeProcessor implements FeeProcessorInterface
{
    private const float FEE_IN_PERCENT = 0.01;

    #[Override]
    public function processFee(Money $money): Money
    {
        $amount =  $money->getAmountInMinorUnit();
        $feeAmount = Amount::fromFloat($amount*self::FEE_IN_PERCENT);

        return $money->add(new Money($feeAmount, $money->getCurrency()));
    }

    #[Override]
    public function supports(Type $enum): bool
    {
        return $enum === Type::PURCHASE;
    }
}
