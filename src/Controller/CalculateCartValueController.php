<?php

declare(strict_types=1);

namespace App\Controller;

use App\CartValueCalculator\CanCalculateCartValue;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CalculateCartValueController
{
    public function calculate(Request $request, CanCalculateCartValue $calculateCartValue) : JsonResponse
    {
        $requestJson = json_decode($request->getContent(), true);

        $checkoutPrice = $calculateCartValue->calculate($requestJson['items'], $requestJson['checkoutCurrency']);

        return new JsonResponse($checkoutPrice);
    }
}
