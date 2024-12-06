<?php $title = 'Добавить новый рецепт';
ob_start(); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="text-center h4 fw-bold mb-4 text-uppercase">Добавить рецепт</h1>

            <form id="createRecipeForm" method="POST" action="/recipe/store" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Название <span class="required-field">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" minlength="3" maxlength="255" required>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug <span class="required-field">*</span></label>
                    <input type="text" class="form-control" id="slug" name="slug" minlength="3" maxlength="255" required>
                </div>

                <div class="mb-3">
                    <label for="ingredients" class="form-label">Ингредиенты <span class="required-field">*</span></label>
                    <textarea class="form-control" name="ingredients" id="ingredients" minlength="10"></textarea>
                </div>

                <div class="mb-3">
                    <label for="instructions" class="form-label">Инструкция <span class="required-field">*</span></label>
                    <textarea class="form-control" name="instructions" id="instructions" minlength="10" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Изображение <span class="required-field">*</span></label>
                    <input class="form-control" type="file" id="image" name="image" required>
                </div>

                <button type="submit" class="btn-default d-block mt-5 mx-auto">Сохранить</button>
            </form>
        </div>
    </div>
</div>

<?php $content = ob_get_clean();
include __DIR__ . '/../layouts/app.php'; ?>
