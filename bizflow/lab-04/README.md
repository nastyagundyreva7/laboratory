# Лабораторная работа №4 — HTML, CSS, Twig, Symfony Forms и Validator

Архив содержит два учебных результата: `sandbox/frontend` (самостоятельная HTML/CSS-песочница) и `bizflow` (Symfony-приложение). Структура предназначена для переноса каталогов в общий учебный Git-репозиторий рядом с `plain-php`.

## Требования

- PHP 8.2 или новее;
- Composer 2;
- расширения PHP, требуемые Symfony (в частности, mbstring рекомендуется для поиска).

## Установка

```bash
cd bizflow
composer install
php bin/console about
php -S 127.0.0.1:8000 -t public
```

Откройте `http://127.0.0.1:8000`. Песочницу HTML/CSS запустите из корня репозитория отдельно:

```bash
php -S 127.0.0.1:8081 -t sandbox/frontend
```

## Что реализовано

- Общий Twig layout с блоками `title`, `stylesheets`, `body`, `javascripts`, меню и partials.
- Страницы dashboard, customers (список/просмотр/создание/редактирование), orders и товары-заглушка.
- Symfony Form `CustomerType`, Symfony Validator constraints и CSRF-защита.
- Redirect и flash после успешного создания/изменения клиента.
- Поиск `?search=` и сортировка `?sort=name|email` с whitelist.
- Twig-фильтры `e`, `lower`, `default`, `length`, `title`, `nl2br` и автоматическое экранирование.
- Обычный CSS без CSS/JS-фреймворков, адаптивная форма и прокрутка таблиц.
- Функциональные тесты: список, форма, создание, пустое имя, email, длина комментария, CSRF и XSS.

## Важное ограничение учебной версии

Репозиторий клиентов в этом задании демонстрационный, хранит данные в памяти процесса и инициализирует примеры при создании сервиса. Это не постоянное хранилище и не подключение к MySQL из лабораторной №2. Для реального сохранения между перезапусками нужно объединить форму с постоянным репозиторием/БД в следующем этапе курса.

## Проверка

```bash
php bin/console lint:twig templates
php bin/console lint:yaml config
php bin/console debug:validator
php bin/phpunit
```

Проверьте интерфейс при ширине 1280, 768 и 360 px, загрузку `/css/frontend-basics.css`, навигацию клавишей Tab и фокус. Дополните `../docs/ai/lab-04.md` реальными результатами. Команды Symfony/PHPUnit необходимо выполнить после установки Composer-зависимостей; в среде подготовки архива зависимости не устанавливались.
