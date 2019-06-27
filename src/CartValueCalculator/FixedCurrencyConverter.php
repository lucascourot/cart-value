<?php

declare(strict_types=1);

namespace App\CartValueCalculator;

use Money\Converter;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Exchange\FixedExchange;
use Money\Exchange\ReversedCurrenciesExchange;
use Money\Money;

final class FixedCurrencyConverter implements CurrencyConverter
{
    public function convert(Money $money, Currency $currency) : Money
    {
        $exchange = new ReversedCurrenciesExchange(new FixedExchange([
            'EUR' => ['USD' => 1.1183],
        ]));

        $converter = new Converter(new ISOCurrencies(), $exchange);

        return $converter->convert($money, $currency);
    }
}
