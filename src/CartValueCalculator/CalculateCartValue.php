<?php

declare(strict_types=1);

namespace App\CartValueCalculator;

use Money\Converter;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Exchange\FixedExchange;
use Money\Exchange\ReversedCurrenciesExchange;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

final class CalculateCartValue implements CanCalculateCartValue
{
    /**
     * @param mixed[] $items
     */
    public function calculate(array $items, string $checkoutCurrency) : Money
    {
        $checkoutPrice = new Money(0, new Currency($checkoutCurrency));

        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);
        $exchange = new ReversedCurrenciesExchange(new FixedExchange([
            'EUR' => ['USD' => 1.1183],
        ]));

        $converter = new Converter($currencies, $exchange);

        foreach ($items as $item) {
            $itemTotalPrice = $moneyParser
                ->parse((string) $item['price'], $item['currency'])
                ->multiply($item['quantity']);

            $itemTotalPriceInCheckoutCurrency = $item['currency'] !== $checkoutCurrency
                ? $converter->convert($itemTotalPrice, new Currency($checkoutCurrency))
                : $itemTotalPrice;

            $checkoutPrice = $checkoutPrice->add($itemTotalPriceInCheckoutCurrency);
        }

        return $checkoutPrice;
    }
}
