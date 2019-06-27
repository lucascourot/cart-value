<?php

declare(strict_types=1);

namespace App\CartValueCalculator;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

final class CalculateCartValue implements CanCalculateCartValue
{
    /** @var CurrencyConverter */
    private $converter;

    public function __construct(CurrencyConverter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @param mixed[] $items
     */
    public function calculate(array $items, string $checkoutCurrency) : Money
    {
        $checkoutPrice = new Money(0, new Currency($checkoutCurrency));

        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        foreach ($items as $item) {
            $itemTotalPrice = $moneyParser
                ->parse((string) $item['price'], $item['currency'])
                ->multiply($item['quantity']);

            $itemTotalPriceInCheckoutCurrency = $item['currency'] !== $checkoutCurrency
                ? $this->converter->convert($itemTotalPrice, new Currency($checkoutCurrency))
                : $itemTotalPrice;

            $checkoutPrice = $checkoutPrice->add($itemTotalPriceInCheckoutCurrency);
        }

        return $checkoutPrice;
    }
}
