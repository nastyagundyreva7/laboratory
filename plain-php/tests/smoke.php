<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Service\QuoteCalculator;

$quote = (new QuoteCalculator())->calculate(10, 1250, 7);
if ($quote->subtotal->cents !== 12500 || $quote->discountAmount->cents !== 875 || $quote->total->cents !== 11625) {
    throw new RuntimeException('Smoke test failed');
}
echo "OK: 10 × 12.50 ₽ − 7% = 116.25 ₽\n";
