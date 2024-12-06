<?php

use app\Controllers\RecipeController;

return [
    '/' => function () {
        include __DIR__ . '/../app/Views/home.php';
    },
    '/recipe/create' => function () {
        require_once __DIR__ . '/../app/Controllers/RecipeController.php';
        $controller = new RecipeController();
        $controller->create();
    }
];
