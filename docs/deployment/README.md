# Развёртывание

Перед production-развёртыванием:
1. Установить зависимости Composer с production-флагом.
2. Выполнить оптимизацию автозагрузчика.
3. Настроить переменные окружения и секреты вне репозитория.
4. Применить миграции контролируемым способом.
5. Настроить права на var/cache и var/log.
6. Настроить веб-сервер так, чтобы document root указывал на public/.
7. Отключить debug и проверить HTTPS, логи и health endpoint.

Пример:
```bash
composer install --no-dev --prefer-dist --optimize-autoloader
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
```
Конкретные команды зависят от структуры и платформы приложения.
