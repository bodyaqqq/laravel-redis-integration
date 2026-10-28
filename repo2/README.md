# Laravel → Redis Pub/Sub → Node.js

```bash
~/redis-7.2.5/src/redis-server --port 6379
cd node-subscriber && node subscriber.js
cd laravel-blog && php artisan serve
```

Страница: `cd frontend && python3 -m http.server 5500 --bind 127.0.0.1`

Docker: `docker compose up --build`