# AI log — анализ производительности запросов

**Запрос агенту (обязательный):**

Проанализируй Doctrine-запросы dashboard. Ищи N+1, лишнюю hydration сущностей, запросы внутри циклов, неиспользуемые JOIN, отсутствующие индексы. Предложи QueryBuilder/DQL для выручки, среднего заказа, top customers, top products. Не используй native SQL без необходимости.

## Реализация

- Выручка: DQL `SUM(i.quantity * i.unitPriceCents)` с join на заказ и фильтром оплаченных/отгруженных статусов.
- Средний заказ: QueryBuilder агрегирует сумму позиций в разрезе заказа; PHP усредняет полученный компактный scalar result. Это исключает загрузку Entity-графа.
- Top customers: QueryBuilder с `SUM(quantity * unitPriceCents)`, `GROUP BY customer`, `ORDER BY revenue DESC`, `LIMIT 5`.
- Top products: QueryBuilder с `SUM(quantity)` и `SUM(quantity * unitPriceCents)`, группировка по продукту.
- Dashboard не обходит коллекции сущностей; N+1 в циклах отсутствует.
- Список заказов выбирает customer одним JOIN. Детали клиента получают только страницу заказов с offset/limit.
- Индексы внешних ключей и фильтров созданы миграцией.

## Проверка
Профилировать реальные планы следует на заполненной MySQL-БД через Symfony profiler и `EXPLAIN` в MySQL. Native SQL не используется.
