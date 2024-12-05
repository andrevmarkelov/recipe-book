<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Книга рецептов</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Шапка -->
    <?php include '../views/layouts/header.php'; ?>

    <!-- Контент -->
    <div id="content">
        <div class="intro">
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-6 mt-5 mb-5">
                        <h1 class="intro-title">Книга рецептов</h1>
                        <p class="intro-subtitle">Добро пожаловать! Здесь собраны рецепты, которые вдохновят вас на создание вкусных блюд.
                            Начните своё кулинарное приключение уже сейчас!</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container py-5">
            <h2 class="recipe-list__title text-center mb-4">Наши рецепты</h2>

            <div class="row justify-content-end">
                <div class="col-md-4 col-lg-3">
                    <div class="recipe-list__action">
                        <form class="d-flex justify-content-between align-items-center gap-3">
                            <div class="mb-3 w-100">
                                <label for="recipeSearch" class="form-label">Поиск</label>
                                <input type="text" class="form-control" id="recipeSearch" placeholder="Поиск рецептов">
                            </div>

                            <div>А</div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <p class="text-center recipe-empty text-muted mt-5">Рецепты пока в пути! Скоро здесь появится много вкусного.</p>

                <div class="col-sm-6 col-lg-4 col-xl-3 mb-4 d-none">
                    <div class="recipe-item">
                        <a href="#" class="recipe-item__image">
                            <img src="#" alt="Заголовок">
                        </a>

                        <div class="recipe-item__content p-4">
                            <a href="#" class="h5 recipe-item__title" title="Заголовок">Заголовок</a>
                            <p class="recipe-item__instructions">Инструкция</p>

                            <a href="#" class="btn-default">Подробнее</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Подвал -->
    <?php include '../views/layouts/footer.php'; ?>

    <!-- Скрипты -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>
