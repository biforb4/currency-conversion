<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Currency;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\CurrencyRates\ExchangeCalculatorInterface;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\FeeCalculationStrategy\FeeProcessorInterface;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Id;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Money;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Type;

class ExchangeTransactionFactory
{

    /** @param list<FeeProcessorInterface> $feeProcessors */
    public function __construct(
        private array $feeProcessors,
        private ExchangeCalculatorInterface $exchangeCalculator
    ) {
    }

    public function createPurchaseTransaction(Money $source, Currency $target): ExchangeTransaction
    {
        return ExchangeTransaction::createPurchaseTransaction(
            new Id('74b369c6-7561-47f1-adeb-64f08db765ea'),
            $source,
            $target,
            $this->findFeeProcessorFor(Type::PURCHASE),
            $this->exchangeCalculator
        );
    }

    public function createSaleTransaction(Money $source, Currency $target): ExchangeTransaction
    {
        return ExchangeTransaction::createPurchaseTransaction(
            new Id('74b369c6-7561-47f1-adeb-64f08db765ea'),
            $source,
            $target,
            $this->findFeeProcessorFor(Type::SALE),
            $this->exchangeCalculator
        );
    }

    private function findFeeProcessorFor(Type $type): FeeProcessorInterface
    {
        foreach ($this->feeProcessors as $feeProcessor) {
            if ($feeProcessor->supports($type)) {
                return $feeProcessor;
            }
        }

        throw new \InvalidArgumentException(
            sprintf('No registered fee processor for transaction type %s', $type->value)
        );
    }
}
