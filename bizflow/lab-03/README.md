# Лабораторная работа №3 — PHP и основы Symfony 7.4

Архив содержит учебную песочницу `sandbox/php-basics/` и проект `bizflow/`.

## Требования
- PHP 8.2 или новее
- Composer 2
- расширения PHP, необходимые Symfony (обычно `ctype`, `iconv`, `json`, `mbstring`, `openssl`, `pdo`)

## 1. PHP-песочница
Из корня архива:

```bash
php -v
php -r "echo 'PHP ', PHP_VERSION, PHP_EOL;"
php sandbox/php-basics/01-procedural.php
php sandbox/php-basics/03-oop.php
php -l sandbox/php-basics/01-procedural.php
php -l sandbox/php-basics/02-web.php
php -l sandbox/php-basics/03-oop.php
php -S 127.0.0.1:8080 -t sandbox/php-basics
```
Откройте `http://127.0.0.1:8080/02-web.php?name=Anna`.

## 2. Symfony
```bash
cd bizflow
composer install
php bin/console about
php bin/console debug:router
php bin/console lint:yaml config
php bin/phpunit
symfony server:start
```
Либо используйте встроенный сервер из каталога `bizflow`:
```bash
php -S 127.0.0.1:8000 -t public
```

Маршруты: `/`, `/health`, `/dashboard`, `/customers`, `/customers/1`, `/orders`, `/orders/1`, `/request-info`, `/api/version` (YAML), `/about` (PHP route config).

## 3. Сохранение вывода маршрутов
После установки зависимостей выполните:
```bash
php bin/console debug:router > ../docs/lab03-routes.txt
```
Затем закоммитьте полученный реальный вывод в общий учебный репозиторий. В архиве `docs/lab03-routes.txt` лежит шаблон-памятка, а не поддельный вывод Symfony.

## Важно
Примеры клиентов и заказов в этой лабораторной хранятся в учебных сервисах в памяти процесса. Это демонстрация маршрутизации и HTTP, а не замена базе данных из лабораторной №2. Контроллеры остаются тонкими: получение данных вынесено в сервисы.
