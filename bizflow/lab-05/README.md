# Лабораторная работа V — Doctrine ORM, сущности, связи, миграции и запросы

Проект `BizFlow` на Symfony 7.4 LTS + Doctrine ORM + MySQL 8.0.

## Требования
- PHP 8.2+, Composer 2, MySQL 8.0+
- Расширения PHP: `pdo_mysql`, `mbstring`, `xml`, `ctype`, `iconv`
- Настроить `DATABASE_URL` в `.env.local`

Пример:
```dotenv
DATABASE_URL="mysql://bizflow:secret@127.0.0.1:3306/bizflow?serverVersion=8.0.36&charset=utf8mb4"
```

## Запуск
```bash
composer install
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
php bin/console doctrine:schema:validate
php bin/console doctrine:migrations:status
php bin/phpunit
symfony server:start
```
Откройте `/dashboard`. Список заказов клиента доступен по `/customers/{id}`; список заказов с пагинацией — `/orders`.

Fixtures используют фиксированный seed и детерминированные наборы данных: 24 клиента, 36 товаров, 60 заказов и не менее 120 позиций. Повторный запуск `doctrine:fixtures:load` очищает таблицы и создаёт одинаковый набор.

## Архитектурные решения
- `Customer` владеет коллекцией `SalesOrder`; owning side — `SalesOrder.customer`.
- `SalesOrder` владеет коллекцией `OrderItem`; owning side — `OrderItem.order`.
- `Product` — inverse side для `OrderItem.product`; owning side — `OrderItem.product`.
- `OrderItem.unitPriceCents` — снимок цены на момент оформления. Изменение цены продукта не переписывает историю.
- Денежные значения хранятся целыми числами в минимальных единицах валюты (центы), без `float`.
- Каскадное удаление не настроено для Customer/Product/SalesOrder. Удаление заказа и его строк выполняется явно в сервисе; `orphanRemoval` выключен, чтобы случайное отсоединение не уничтожало историю.
- Для часто используемых фильтров добавлены индексы; email и SKU уникальны.
- Dashboard получает DTO/скалярные результаты через сервис, EntityManager и SQL в Twig не передаются.

## Проверки
`doctrine:schema:validate` и PHPUnit требуют установленных Composer-зависимостей и доступной MySQL-БД. Синтаксис PHP в архиве проверен; runtime-команды необходимо выполнить в вашей среде.
