# Интеграция Laravel с Python и Node.js через Redis

- `repo/` — задание 1: Laravel, очередь Redis, Python-воркер (LaraQueue)
- `repo2/` — задание 2: Laravel, Redis Pub/Sub, Node.js-подписчик

В каждой папке свой `README.md` с командами запуска.

## Первая установка Laravel (в `laravel-blog` каждой папки)

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
```

В `.env` должно быть `REDIS_CLIENT=predis`, `REDIS_PREFIX=` (пустой),
для задания 1 ещё `QUEUE_CONNECTION=redis`.

Для Docker в корне нужной папки создайте `.env` с `HOST_UID` и
`HOST_GID` (значения из `id -u` и `id -g`).