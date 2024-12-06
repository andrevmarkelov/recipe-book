<?php

namespace app\Controllers;

require_once __DIR__ . '/../Models/Recipe.php';
require_once __DIR__ . '/../Helpers/Validation.php';

use app\Helpers\Validation;
use app\Models\Recipe;

class RecipeController
{
    /**
     * Главная страница
     *
     * @return void
     */
    public function index(): void
    {
        $recipes = Recipe::index();
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

    /**
     * Создание рецепта
     *
     * @return void
     */
    public function store(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Метод не разрешён']);
            exit;
        }

        $errors = Validation::validateRecipe($_POST, $_FILES);

        if (!empty($errors)) {
            echo json_encode(['status' => 'error', 'errors' => $errors]);
            exit;
        }

        if (empty($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['status' => 'error', 'message' => 'Необходимо загрузить изображение']);
            exit;
        }

        $uploadDir = __DIR__ . '/../../public/assets/images/recipe-images/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
                echo json_encode(['status' => 'error', 'message' => 'Не удалось создать директорию для загрузки изображений']);
                return;
            }
        }

        $slug = $_POST['slug'];
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = $slug . '.' . $extension;
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
            echo json_encode(['status' => 'error', 'message' => 'Ошибка загрузки изображения.']);
            return;
        }

        Recipe::store($_POST['title'], $_POST['slug'], $_POST['ingredients'], $_POST['instructions'], $fileName);
        echo json_encode(['status' => 'success', 'message' => 'Рецепт был успешно сохранён']);
    }
}
