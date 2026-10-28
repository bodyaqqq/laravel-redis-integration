const Redis = require('ioredis');
const fs = require('fs');

const LOG_FILE = process.env.LOG_FILE || 'notifications.log';

const sub = new Redis({
  host: process.env.REDIS_HOST || '127.0.0.1',
  port: Number(process.env.REDIS_PORT || 6379),
});

sub.subscribe('orders', (err) => {
  if (err) {
    console.error('Ошибка подписки:', err.message);
    process.exit(1);
  }
  console.log('Подписчик запущен, слушаю канал orders...');
});

sub.on('message', (channel, message) => {
  try {
    const o = JSON.parse(message);
    const line = `[NOTIFY] Заказ #${o.id}: "${o.item}" x${o.qty}`;
    console.log(line);
    fs.appendFileSync(LOG_FILE, line + '\n');
  } catch (e) {
    console.error('Некорректное сообщение:', message);
  }
});