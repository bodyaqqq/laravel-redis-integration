# Laravel → Redis → Python

Запуск (три терминала, порядок важен):

```bash
~/redis-7.2.5/src/redis-server --port 6379                                      
cd python-worker && source .venv/bin/activate && python worker.py                
cd laravel-app && php artisan serve                                              
```

Страница: `cd frontend && python3 -m http.server 5500 --bind 127.0.0.1`, затем http://127.0.0.1:5500

## Первая установка
- Laravel: `cd laravel-app && composer install && php artisan migrate`
- Python: `cd python-worker && python3 -m venv .venv && source .venv/bin/activate && pip install -r requirements.txt`
- В `.env` Laravel: `QUEUE_CONNECTION=redis`, `REDIS_CLIENT=predis`, `REDIS_PREFIX=` (пустой!)

## Проверка очереди
`redis-cli LLEN queues:python-notify`

## Примечание
LaraQueue ищет ключ `laravel_database_queues:<имя>`, а Laravel без префикса кладёт в `queues:<имя>`. В `worker.py` метод `_build_queue_key` переопределён, чтобы читался ключ без префикса.

## Запуск с помощью Docker 
docker compose up -d