<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Currency;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\CurrencyRates\ExchangeCalculatorInterface;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\FeeCalculationStrategy\FeeProcessorInterface;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Id;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Money;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Status;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Type;

final class ExchangeTransaction
{
    private Id $id;
    private Money $sourceMoney;
    private ?Money $targetMoney;
    private Currency $targetCurrency;
    private Status $status = Status::NEW;
    private Type $type;

    private FeeProcessorInterface $feeProcessor;
    private ExchangeCalculatorInterface $exchangeCalculator;

    private function __construct(Id $id, Money $sourceMoney, Currency $targetCurrency, Type $type)
    {
        $this->id = $id;
        $this->sourceMoney = $sourceMoney;
        $this->targetCurrency = $targetCurrency;
        $this->type = $type;
    }

    public static function createPurchaseTransaction(
        Id $id,
        Money $sourceMoney,
        Currency $targetCurrency,
        FeeProcessorInterface $feeProcessor,
        ExchangeCalculatorInterface $exchangeCalculator
    ): self {
        $transaction  = new self($id, $sourceMoney, $targetCurrency, Type::PURCHASE);
        $transaction->feeProcessor = $feeProcessor;
        $transaction->exchangeCalculator = $exchangeCalculator;

        return $transaction;
    }

    public static function createSaleTransaction(
        Id $id,
        Money $sourceMoney,
        Currency $targetCurrency,
        FeeProcessorInterface $feeProcessor,
        ExchangeCalculatorInterface $exchangeCalculator
    ): self {
        $transaction  = new self($id, $sourceMoney, $targetCurrency, Type::SALE);
        $transaction->feeProcessor = $feeProcessor;
        $transaction->exchangeCalculator = $exchangeCalculator;

        return $transaction;
    }

    public function execute(): ExchangeTransactionExecutedEvent
    {
        $targetMoney = $this->exchangeCalculator->calculate($this->sourceMoney, $this->targetCurrency);
        $this->targetMoney = $this->feeProcessor->processFee($targetMoney);

        $this->status = Status::EXECUTED;

        return new ExchangeTransactionExecutedEvent($this->id, $this->sourceMoney, $this->targetMoney);
    }
}
