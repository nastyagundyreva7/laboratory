INSERT INTO customers (name, email) VALUES
('Анна Смирнова', 'anna@example.test'),
('Иван Петров', 'ivan@example.test'),
('Мария Кузнецова', 'maria@example.test')
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO orders (customer_id, description, amount_cents, status)
SELECT c.id, seed.description, seed.amount_cents, seed.status
FROM customers c
JOIN (
  SELECT 'Набор монет RUD' AS description, 159900 AS amount_cents, 'paid' AS status, 'anna@example.test' AS email
  UNION ALL SELECT 'Подарочный сертификат', 250000, 'new', 'ivan@example.test'
  UNION ALL SELECT 'Коллекционный альбом', 89900, 'paid', 'maria@example.test'
) seed ON seed.email = c.email
WHERE NOT EXISTS (SELECT 1 FROM orders o WHERE o.customer_id = c.id AND o.description = seed.description);
