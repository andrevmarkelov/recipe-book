<?php $title = 'Книга рецептов';
ob_start(); ?>

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
        <?php if (!empty($recipes)): ?>
            <?php foreach ($recipes as $recipe): ?>
                <div class="col-sm-6 col-lg-4 col-xl-3 mb-4">
                    <div class="recipe-item">
                        <a href="<?php echo htmlspecialchars($recipe['slug']); ?>" class="recipe-item__image">
                            <img src="/public/assets/images/recipe-images/<?php echo htmlspecialchars($recipe['image_path']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                        </a>

                        <div class="recipe-item__content p-4">
                            <a href="<?php echo htmlspecialchars($recipe['slug']); ?>" class="h5 recipe-item__title" title="<?php echo htmlspecialchars($recipe['title']); ?>"><?php echo htmlspecialchars($recipe['title']); ?></a>
                            <p class="recipe-item__instructions"><?php echo htmlspecialchars($recipe['instructions']); ?></p>

                            <a href="<?php echo htmlspecialchars($recipe['slug']); ?>" class="btn-default">Подробнее</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center recipe-empty text-muted mt-5">Рецепты пока в пути! Скоро здесь появится много вкусного.</p>
        <?php endif; ?>
    </div>
</div>

<?php  $content = ob_get_clean();
include __DIR__ . '/../Views/layouts/app.php'; ?>
