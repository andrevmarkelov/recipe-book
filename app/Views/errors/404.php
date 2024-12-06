<?php $title = 'Страница не найдена';
ob_start(); ?>

<div class="container py-5">
    <h1 class="text-center">404</h1>
    <p class="text-center">Страница не найдена. Вернитесь на <a href="/">главную страницу</a>.</p>
</div>

<?php $content = ob_get_clean();
include __DIR__ . '/../layouts/app.php'; ?>
