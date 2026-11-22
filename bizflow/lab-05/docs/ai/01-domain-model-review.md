# AI log — проверка доменной модели

**Запрос агенту (обязательный):**

Ты — senior Symfony/Doctrine architect. Проанализируй Customer, Product, SalesOrder, OrderItem. Проверь кардинальности; owning/inverse side; cascade; orphanRemoval; индексы; unique constraints; nullable; тип денежных полей. Особое внимание: N+1, случайное удаление связанных объектов, потеря истории цены товара. Предложи исправления до создания миграции.

## Результат анализа и принятые решения

- `Customer 1:N SalesOrder`: inverse side — `Customer.orders` (`mappedBy=customer`), owning side — `SalesOrder.customer` (`ManyToOne`).
- `SalesOrder 1:N OrderItem`: inverse side — `SalesOrder.items`, owning side — `OrderItem.order`.
- `Product 1:N OrderItem`: inverse side — `Product.orderItems`, owning side — `OrderItem.product`.
- Внешние ключи обязательные (`nullable=false`) и `ON DELETE RESTRICT`. Cascade remove и orphanRemoval не включены: клиент, товар или заказ не должны исчезать вместе с историческими продажами из-за удаления объекта из коллекции.
- `email` и `sku` имеют уникальные ограничения. Для customer.createdAt, product.active, order.status+createdAt, order.customer+createdAt, order_item.order_id и order_item.product_id добавлены индексы.
- Деньги представлены `INT` в центах; PHP `int`; `float` не используется для хранения денег.
- `OrderItem.unitPriceCents` сохраняет цену на момент покупки. Отображение исторических заказов не зависит от текущей цены `Product.priceCents`.
- Для dashboard агрегаты возвращаются как скалярные массивы, а не полные графы сущностей. Страница списка заказов использует join к customer; пагинация клиентских заказов ограничивает выборку.

## Ограничения
Для полноценного production-приложения потребуются политика архивирования, аудит изменений, валютный код, защита от переполнения integer и доменные правила переходов статусов.
