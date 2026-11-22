<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\Service\QuoteCalculator;
use InvalidArgumentException;
use Throwable;

final readonly class QuoteController
{
    public function __construct(private QuoteCalculator $calculator) {}

    public function __invoke(Request $request): Response
    {
        foreach (['qty', 'price', 'discount'] as $key) {
            if (!array_key_exists($key, $request->query) || $request->queryInt($key) === null) {
                return new Response($this->page('Проверьте параметры', '<p>Параметры qty, price и discount должны быть целыми числами.</p>'), 400);
            }
        }

        try {
            $quote = $this->calculator->calculate(
                $request->queryInt('qty'),
                $request->queryInt('price'),
                $request->queryInt('discount'),
            );
        } catch (InvalidArgumentException $exception) {
            return new Response($this->page('Некорректные данные', '<p>' . self::escape($exception->getMessage()) . '</p>'), 400);
        } catch (Throwable) {
            return new Response($this->page('Внутренняя ошибка', '<p>Не удалось выполнить расчет.</p>'), 500);
        }

        $content = sprintf(
            '<div class="result-grid"><div><span>Количество</span><strong>%d шт.</strong></div><div><span>Цена за единицу</span><strong>%s</strong></div><div><span>Сумма до скидки</span><strong>%s</strong></div><div><span>Скидка (%d%%)</span><strong>− %s</strong></div></div><p class="total">Итого: %s</p>',
            $quote->quantity,
            self::escape($quote->unitPrice->format()),
            self::escape($quote->subtotal->format()),
            $quote->discountPercent,
            self::escape($quote->discountAmount->format()),
            self::escape($quote->total->format()),
        );
        return new Response($this->page('Расчет стоимости', $content));
    }

    private function page(string $title, string $content): string
    {
        return '<!doctype html><html lang="ru"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>' . self::escape($title) . ' — RUD COIN</title><link rel="stylesheet" href="/style.css"></head><body><main class="shell"><a class="brand" href="/">RUD <b>COIN</b></a><section class="panel"><p class="eyebrow">КАЛЬКУЛЯТОР / УЧЕБНЫЙ МОДУЛЬ</p><h1>' . self::escape($title) . '</h1>' . $content . '<a class="back" href="/">← На главную</a></section></main></body></html>';
    }

    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
