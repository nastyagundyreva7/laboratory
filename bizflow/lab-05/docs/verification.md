# Самопроверка

```bash
php bin/console doctrine:schema:validate
php bin/console doctrine:migrations:status
php bin/phpunit
```

## Матрица покрытия
- Unit: вычисление суммы позиции; целочисленные денежные значения; фиксация исторической цены; валидация quantity; нормализация email; допустимость статусов; запрет отрицательной стоимости.
- Functional: dashboard; список заказов; фильтр статуса; 404 клиента; клиентская страница (с fixtures в test DB).
- Для functional tests предварительно создайте test DB, выполните миграции и загрузите fixtures:
```bash
APP_ENV=test php bin/console doctrine:database:create --if-not-exists
APP_ENV=test php bin/console doctrine:migrations:migrate --no-interaction
APP_ENV=test php bin/console doctrine:fixtures:load --no-interaction
```
