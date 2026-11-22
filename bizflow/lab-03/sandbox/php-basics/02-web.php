<?php
declare(strict_types=1);
$name = trim((string) ($_GET['name'] ?? 'Гость'));
?>
<!doctype html>
<html lang="ru">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>BizFlow PHP Sandbox</title></head>
<body>
<h1>BizFlow</h1>
<p>Здравствуйте, <?= htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
</body>
</html>
