# PHP Web Course

Учебный репозиторий лабораторных работ по PHP, MySQL и Symfony.

## Структура

```text
php-web-course/
├── plain-php/
├── bizflow/
├── framework-comparison/
├── deploy/
├── docs/
│   ├── ai/                 # журналы ИИ и prompts lab-01 ... lab-12
│   ├── security/
│   ├── deployment/
│   └── framework-choice.md
└── README.md
```

## Единый формат сдачи

Студент сдаёт Git-репозиторий с исходным кодом, инструкциями запуска, тестами и журналами использования ИИ в `docs/ai/`. Перед сдачей необходимо:
1. Проверить `composer.json` через `composer validate`.
2. Установить зависимости и выполнить тесты каждой лабораторной.
3. Проверить отсутствие секретов, локальных конфигураций и `.env` в Git.
4. Заполнить фактические результаты проверок в соответствующем `docs/ai/lab-NN.md`.
5. Создать Git-тег после завершения каждой лабораторной.

Обязательные Git-теги: `lab-01`, `lab-02`, `lab-03`, `lab-04`, `lab-05`, `lab-06`, `lab-07`, `lab-08`, `lab-09`, `lab-10`, `lab-11`, `lab-12`.

Команда для создания очередного тега (после коммита соответствующей лабораторной):
```bash
git tag lab-01
git push origin lab-01
```
Повторить с актуальным номером лабораторной. Не ставить все теги на один и тот же итоговый коммит.

## Техническая база и источники

Требования комплекта ориентируются на актуальную документацию PHP, Composer, Symfony, Doctrine, Twig, PHPUnit, FOSRestBundle, NelmioApiDocBundle и Flysystem. В исходном задании указаны PHP 8.2–8.5, Symfony 7.4 LTS и Symfony 8.1 feature/stable. Перед выбором версии проекта сверяйте её с официальной документацией и совместимостью пакетов.

- PHP releases: https://www.php.net/releases/index.php
- Composer: https://getcomposer.org/doc/
- Symfony routing: https://symfony.com/doc/current/routing.html
- Symfony documentation: https://symfony.com/doc/current/
- Doctrine ORM: https://www.doctrine-project.org/projects/doctrine-orm/en/latest/index.html
- Twig: https://twig.symfony.com/doc/
- PHPUnit: https://docs.phpunit.de/
- FOSRestBundle: https://fosrestbundle.readthedocs.io/
- NelmioApiDocBundle: https://symfony.com/bundles/NelmioApiDocBundle/current/index.html
- Flysystem: https://flysystem.thephpleague.com/

## Состав материалов

В текущем комплекте приложены исходные архивы лабораторных №1–5. Они сохранены как отдельные исходные комплекты, поскольку лабораторные №2–5 содержат последовательные, но не полностью взаимозаменяемые версии BizFlow. Не объединяйте их поверх друг друга без проверки различий. Лабораторные №6–12 добавляются в репозиторий по мере получения заданий.

## Безопасность

Не коммитьте реальные пароли, токены, ключи и локальные файлы окружения. Используйте `.env.example` с демонстрационными значениями и `.env.local` для локальной настройки.
