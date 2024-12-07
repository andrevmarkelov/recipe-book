<?php $title = 'Редактировать рецепт';
$scripts = ['edit-recipe.js'];
ob_start(); ?>

<div class="container pt-2 pb-5">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-black">Главная</a></li>
            <li class="breadcrumb-item"><a href="/recipe/<?php echo htmlspecialchars($recipe['slug']); ?>" class="text-black"><?php echo htmlspecialchars($recipe['title']); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Редактировать рецепт</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="text-center h4 fw-bold mb-4 text-uppercase">Редактировать рецепт</h1>

            <form id="editRecipeForm" method="POST" action="/recipe/<?php echo htmlspecialchars($recipe['slug']); ?>/update" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Название <span class="required-field">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" minlength="3" maxlength="255" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="ingredients" class="form-label">Ингредиенты <span class="required-field">*</span></label>
                    <textarea class="form-control" name="ingredients" id="ingredients" minlength="10"><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="instructions" class="form-label">Инструкция <span class="required-field">*</span></label>
                    <textarea class="form-control" name="instructions" id="instructions" minlength="10" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Изображение</label>
                    <input class="form-control" type="file" id="image" name="image">
                    <img src="/public/assets/images/recipe-images/<?php echo htmlspecialchars($recipe['image_path']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>" class="d-block m-auto img-thumbnail w-50 mt-3">
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-5">
                    <button type="submit" class="btn-default">Сохранить</button>
                    <p class="text-center mb-0"><strong>Последнее обновление:</strong> <?php echo date('d.m.Y', strtotime($recipe['updated_at'])); ?></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $content = ob_get_clean();
include __DIR__ . '/../layouts/app.php'; ?>
