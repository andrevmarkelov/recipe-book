<?php $title = htmlspecialchars($recipe['title']);
ob_start(); ?>

<div class="container pt-2 pb-5">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-black">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($recipe['title']); ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="recipe-image">
                <img src="/public/assets/images/recipe-images/<?php echo htmlspecialchars($recipe['image_path']); ?>" alt="<?php echo htmlspecialchars($recipe['title']) ?>">
            </div>
        </div>
        <div class="col-md-7 mb-4">
            <div class="recipe-detail">
                <h1 class="h2 text-sm-start text-center mb-4"><?php echo htmlspecialchars($recipe['title']); ?></h1>
                <p class="mb-0"><strong>Ингредиенты:</strong> <?php echo htmlspecialchars($recipe['ingredients']); ?></p>
                <p><strong>Инструкция:</strong> <?php echo htmlspecialchars($recipe['instructions']); ?></p>
                <p><strong>Добавлен:</strong> <?php echo date('d.m.Y', strtotime($recipe['created_at'])); ?></p>

                <div class="d-flex align-items-center flex-wrap gap-3 mt-5">
                    <a href="#" class="btn-default">Редактировать</a>
                    <button type="button" class="btn-default" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        Удалить
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Удаление рецепта</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Вы уверены, что хотите удалить этот рецепт? Это действие нельзя отменить</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-outline-danger">Удалить</button>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean();
include __DIR__ . '/../layouts/app.php'; ?>
