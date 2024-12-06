<?php

use app\Controllers\RecipeController;

return [
    '/' => function () {
        $controller = new RecipeController();
        $controller->index();
    },
    '/recipe/create' => function () {
        require_once __DIR__ . '/../app/Controllers/RecipeController.php';
        $controller = new RecipeController();
        $controller->create();
    },
    '/recipe/store' => function () {
        $controller = new RecipeController();
        $controller->store();
    }
];
