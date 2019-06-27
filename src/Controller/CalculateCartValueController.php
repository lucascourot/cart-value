<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class CalculateCartValueController
{
    public function calculate() : JsonResponse
    {
        return new JsonResponse([
            'checkoutPrice' => 82.18,
            'checkoutCurrency' => 'EUR',
        ]);
    }
}
