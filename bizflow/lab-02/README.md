# BizFlow — лабораторная работа №2: MySQL и репозитории

Учебный PHP 8.2+ проект на MySQL. В проекте показаны два способа работы с MySQL: PDO и MySQLi, репозитории, подготовленные выражения, транзакция, JOIN/GROUP BY отчёты и интеграционный тест SQL-инъекции.

## 1. Требования
- PHP 8.2+ с расширениями `pdo_mysql` и `mysqli`
- Composer 2
- MySQL 8.0+

## 2. Установка
```bash
cp .env.example .env
composer install
```
Создайте базы данных (пользователь должен иметь права на обе):
```sql
CREATE DATABASE bizflow CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE bizflow_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
Заполните параметры подключения в `.env` и экспортируйте их в окружение (сам PHP не читает `.env` автоматически). Например, в Bash:
```bash
set -a; source .env; set +a
```
Затем:
```bash
composer dump-autoload
php database/migrate.php
php database/seed.php
```

## 3. Запуск
```bash
php -S localhost:8000 -t public
```
Откройте `http://localhost:8000/`.

## 4. Маршруты API
| Метод и путь | Назначение |
|---|---|
| `GET /` | описание приложения и маршрутов |
| `GET /health` | проверка доступности приложения |
| `GET /customers/find?email=anna@example.test` | поиск клиента через MySQLi prepared statement |
| `GET /orders?id=1` | заказ по ID через PDO |
| `GET /orders/search?q=монет` | поиск заказов через PDO prepared statement |
| `POST /orders` | создание заказа и audit-записи в одной транзакции |
| `GET /reports/status` | количество и сумма заказов по статусам |
| `GET /reports/customers?limit=10` | сводка по клиентам через LEFT JOIN и GROUP BY |

Пример создания заказа:
```bash
curl -X POST http://localhost:8000/orders \\
  -H 'Content-Type: application/json' \\
  -d '{"customer_id":1,"description":"Новый заказ","amount_cents":12500}'
```
Суммы хранятся в целых копейках, чтобы не использовать двоичную арифметику float для денег.

## 5. Структура
- `src/Database/ConnectionFactory.php` — соединения PDO и MySQLi
- `src/Repository/OrderRepository.php` — PDO: CRUD/поиск и транзакция
- `src/Repository/CustomerMysqliRepository.php` — MySQLi: поиск и создание клиента
- `src/Repository/ReportRepository.php` — агрегатные отчёты
- `src/Service/OrderService.php` — проверка входных данных
- `database/migrations/` — схема таблиц и индексов
- `database/seeds/` — демонстрационные данные
- `tests/Integration/` — тесты, требующие MySQL
- `docs/ai/lab-02.md` — журнал использования ИИ

## 6. Тестирование
Сначала примените миграцию к отдельной тестовой БД, затем запустите PHPUnit:
```bash
DB_NAME=bizflow_test php database/migrate.php
DB_NAME=bizflow_test vendor/bin/phpunit
```
(Если используете `.env`, перед этим экспортируйте его переменные в окружение.)
Тест `SqlInjectionTest` проверяет, что строка ` ' OR '1'='1 ` обрабатывается как значение, а не как часть SQL. `OrderTransactionTest` проверяет наличие заказа и связанной записи аудита.

## 7. Важные замечания
- Значения пользователя передаются через плейсхолдеры prepared statements. Имена таблиц/колонок и SQL-ключевые слова нельзя безопасно передавать как параметры; динамические части SQL должны выбираться из белого списка.
- PDO настроен на исключения и отключённую эмуляцию подготовленных выражений.
- `LIMIT` валидируется и ограничивается до интерполяции как целое число.
- Не используйте рабочую базу для интеграционных тестов: тесты создают/добавляют записи.
