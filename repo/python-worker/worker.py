import os
import sys
import logging
from redis import Redis
from lara_queue import Queue

logging.basicConfig(level=logging.WARNING)
sys.stdout.reconfigure(encoding="utf-8")


class PlainQueue(Queue):
    """Читаем ключ без префикса: queues:<имя>, как кладёт Laravel (REDIS_PREFIX=)."""

    def _build_queue_key(self, queue_name=None):
        return f"queues:{queue_name or self.queue}"


r = Redis(
    host=os.getenv("REDIS_HOST", "127.0.0.1"),
    port=int(os.getenv("REDIS_PORT", "6379")),
    db=0,
)
queue = PlainQueue(r, queue="python-notify")


def txt(v):
    return v.decode("utf-8") if isinstance(v, bytes) else v


@queue.handler
def handle(data):
    job = {txt(k): v for k, v in data["data"].items()}
    line = f'[NOTIFY] Заказ #{job["id"]}: "{txt(job["item"])}" x{job["qty"]}'
    print(line, flush=True)
    with open("notifications.log", "a", encoding="utf-8") as f:
        f.write(line + "\n")


print("Воркер запущен, слушаю очередь python-notify...", flush=True)
queue.listen()