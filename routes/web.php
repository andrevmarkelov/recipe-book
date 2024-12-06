<?php

require_once __DIR__ . '/../app/Controllers/RecipeController.php';

use app\Controllers\RecipeController;

return [
    '/' => function () {
        $controller = new RecipeController();
        $controller->index();
    },
    '/recipe/create' => function () {
        $controller = new RecipeController();
        $controller->create();
    },
    '/recipe/store' => function () {
        $controller = new RecipeController();
        $controller->store();
    },
    '/recipe/{slug}' => function ($slug) {
        $controller = new RecipeController();
        $controller->show($slug);
    },
];
