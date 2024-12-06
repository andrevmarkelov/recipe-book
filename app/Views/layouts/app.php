<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title ?? 'Книга рецептов'; ?></title>
    <link rel="icon" type="image/x-icon" href="/public/favicon.ico">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
</head>
<body>

    <!-- Шапка -->
    <?php include __DIR__ . '/header.php'; ?>

    <!-- Контент -->
    <div id="content">
        <?php echo $content ?? '<p>Контент отсутствует.</p>' ?>
    </div>

    <!-- Подвал -->
    <?php include __DIR__ . '/footer.php'; ?>

    <!-- Скрипты -->
    <script src="/public/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/scripts.js"></script>
</body>
</html>
