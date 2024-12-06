<?php

namespace app\Controllers;

class RecipeController
{
    /**
     * Главная страница
     *
     * @return void
     */
    public function index(): void
    {
        include __DIR__ . '/../Views/home.php';
    }

    /**
     * Форма с добавлением рецепта
     *
     * @return void
     */
    public function create(): void
    {
        include __DIR__ . '/../Views/recipes/create.php';
    }
}
