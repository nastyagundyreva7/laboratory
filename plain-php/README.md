# RUD COIN — лабораторная работа №1

Учебное серверное приложение на PHP 8.2+ без фреймворка. Главная страница оформлена по мотивам предоставленного сайта RUD COIN; бизнес-часть лабораторной демонстрирует HTTP, Composer, PSR-4, ООП и независимый расчет стоимости.

## Требования
- PHP 8.2 или новее
- Composer 2

## Установка и запуск
```bash
composer install
composer dump-autoload
php -S localhost:8000 -t public
```
Откройте http://localhost:8000.

## Маршруты
- `GET /` — главная страница RUD COIN
- `GET /health` — JSON о состоянии приложения
- `GET /about` — информация о прототипе
- `GET /quote?qty=10&price=1250&discount=7` — расчет (цена задается в копейках)

Проверка:
```bash
curl -i http://localhost:8000/health
curl -i 'http://localhost:8000/quote?qty=10&price=1250&discount=7'
curl -i 'http://localhost:8000/quote?qty=-1&price=1250&discount=7'
curl -i http://localhost:8000/unknown
```

## Тесты
```bash
composer install
vendor/bin/phpunit
```

## Важно
Пароли и реальные секреты в проект не добавлялись. Для лабораторной №1 база данных не требуется. Перед сдачей создайте Git-тег `lab-01` после проверки.
