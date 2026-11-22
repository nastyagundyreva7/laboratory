<?php

declare(strict_types=1);

use App\Controller\QuoteController;
use App\Http\Request;
use App\Http\Response;
use App\Service\QuoteCalculator;

require dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::fromGlobals();

try {
    if ($request->method !== 'GET') {
        $response = new Response('<h1>405 Method Not Allowed</h1>', 405, ['Content-Type' => 'text/html; charset=UTF-8', 'Allow' => 'GET']);
    } else {
        $response = match ($request->path) {
            '/' => new Response(<<<'HTML'
<!doctype html>
<html lang="ru"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>RUD COIN — студенческая программа</title><link rel="stylesheet" href="/style.css"></head>
<body><header class="top"><a class="brand" href="/">RUD <b>COIN</b></a><nav><a href="/#how">Как это работает</a><a href="/about">О проекте</a><a href="/quote?qty=10&price=1250&discount=7">Калькулятор</a></nav><a class="login" href="/health">Статус системы</a></header>
<main><section class="hero"><div class="hero-copy"><p class="eyebrow">СТУДЕНЧЕСКАЯ ПРОГРАММА ЛОЯЛЬНОСТИ РУДН</p><h1>Твоя активность<br><em>имеет ценность.</em></h1><p class="lead">Участвуй в мероприятиях университета, развивайся и получай RUD COIN за реальные достижения.</p><div class="actions"><a class="button" href="/about">Узнать о проекте</a><a class="text-link" href="/quote?qty=10&price=1250&discount=7">Открыть калькулятор →</a></div></div><div class="coin-art"><div class="coin">R<span>DC</span></div><p>УЧАСТВУЙ · РАЗВИВАЙСЯ · ПОЛУЧАЙ</p></div></section>
<section id="how" class="steps"><article><small>01 / ВЫБЕРИ</small><h2>Мероприятие</h2><p>Найди интересную активность в университете.</p></article><article><small>02 / УЧАСТВУЙ</small><h2>Будь активным</h2><p>Посещай события и развивай свои навыки.</p></article><article><small>03 / ПОЛУЧИ</small><h2>RUD COIN</h2><p>После подтверждения участия получи монеты.</p></article><article><small>04 / ОБМЕНИВАЙ</small><h2>Привилегии</h2><p>Используй накопленное для доступа к бонусам.</p></article></section>
<section class="note"><div><p class="eyebrow">УЧЕБНЫЙ ПРОТОТИП</p><h2>Начинаем с надежной основы</h2><p>Это первая версия проекта: PHP без фреймворка, единая точка входа, типизированная бизнес-логика и тестируемый расчет.</p></div><a class="button button-light" href="/quote?qty=10&price=1250&discount=7">Попробовать расчет</a></section></main><footer>RUD COIN · Учебный проект · PHP 8+</footer></body></html>
HTML,
                ),
            '/health' => Response::json(['status' => 'ok', 'php' => PHP_VERSION, 'timestamp' => (new DateTimeImmutable())->format(DateTimeInterface::ATOM)]),
            '/about' => new Response('<!doctype html><html lang="ru"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>О проекте — RUD COIN</title><link rel="stylesheet" href="/style.css"></head><body><main class="shell"><a class="brand" href="/">RUD <b>COIN</b></a><section class="panel"><p class="eyebrow">О ПРОЕКТЕ</p><h1>RUD COIN</h1><p>Учебный прототип студенческой программы лояльности РУДН. Идея проекта — поощрять участие студентов в университетских мероприятиях внутренними бонусными баллами.</p><p>В лабораторной №1 реализованы HTTP-маршруты, Composer, PSR-4, ООП и отдельный сервис расчета стоимости.</p><a class="back" href="/">← На главную</a></section></main></body></html>'),
            '/quote' => (new QuoteController(new QuoteCalculator()))($request),
            default => new Response('<!doctype html><html lang="ru"><head><meta charset="UTF-8"><title>404</title><link rel="stylesheet" href="/style.css"></head><body><main class="shell"><section class="panel"><p class="eyebrow">ОШИБКА 404</p><h1>Страница не найдена</h1><p>Такого адреса нет в приложении.</p><a class="back" href="/">← На главную</a></section></main></body></html>', 404),
        };
    }
} catch (Throwable) {
    $response = new Response('Внутренняя ошибка сервера.', 500);
}

$response->send();
