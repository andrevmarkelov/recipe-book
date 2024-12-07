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
            echo json_encode(['status' => 'error', 'message' => 'Ошибка загрузки изображения']);
            return;
        }

        Recipe::store($_POST['title'], $_POST['slug'], $_POST['ingredients'], $_POST['instructions'], $fileName);
        echo json_encode(['status' => 'success', 'message' => 'Рецепт был успешно сохранён']);
    }

    /**
     * Отображаем страницу рецепта по слагу
     *
     * @param string $slug Уникальный slug рецепта
     * @return void
     */
    public function show(string $slug): void
    {
        $recipe = Recipe::findBySlug($slug);

        if (!$recipe) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            return;
        }

        include __DIR__ . '/../Views/recipes/show.php';
    }

    /**
     * Отображаем страницу редактирования рецепта
     *
     * @param string $slug
     * @return void
     */
    public function edit(string $slug): void
    {
        $recipe = Recipe::findBySlug($slug);

        if (!$recipe) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            return;
        }

        include __DIR__ . '/../Views/recipes/edit.php';
    }

    /**
     * Обновляем рецепт по slug
     *
     * @param string $slug
     * @return void
     */
    public function update(string $slug): void
    {
        $recipe = Recipe::findBySlug($slug);

        if (!$recipe) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['status' => 'error', 'message' => 'Рецепт не найден']);
            return;
        }

        $errors = Validation::validateRecipe($_POST, $_FILES, 'update');
        if (!empty($errors)) {
            header('HTTP/1.1 422 Unprocessable Entity');
            echo json_encode(['status' => 'error', 'errors' => $errors]);
            return;
        }

        $imagePath = $recipe['image_path'];
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../../public/assets/images/recipe-images/';
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = $slug . '.' . $extension;
            $filePath = $uploadDir . $fileName;

            $oldImagePath = $uploadDir . $recipe['image_path'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['status' => 'error', 'message' => 'Ошибка загрузки изображения']);
                return;
            }

            $imagePath = $fileName;
        }

        $updated = Recipe::update($slug, $_POST['title'], $_POST['ingredients'], $_POST['instructions'], $imagePath);

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Рецепт успешно обновлён']);
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['status' => 'error', 'message' => 'Не удалось обновить рецепт']);
        }
    }

    /**
     * Удаляем рецепт и его изображение по slug
     *
     * @param string $slug
     * @return void
     */
    public function delete(string $slug): void
    {
        $recipe = Recipe::findBySlug($slug);

        if (!$recipe) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['status' => 'error', 'message' => 'Рецепт не найден']);
            return;
        }

        $uploadDir = __DIR__ . '/../../public/assets/images/recipe-images/';
        $imagePath = $uploadDir . $recipe['image_path'];

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $deleted = Recipe::deleteBySlug($slug);

        if ($deleted) {
            echo json_encode(['status' => 'success', 'message' => 'Рецепт успешно удалён']);
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['status' => 'error', 'message' => 'Не удалось удалить рецепт']);
        }
    }

    /**
     * Возвращаем список рецептов с поиском и сортировкой
     *
     * @return void
     */
    public function filter(): void
    {
        header('Content-Type: application/json');

        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'asc';

        $recipes = Recipe::searchAndSort($search, $sort);

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'recipes' => $recipes]);
    }
}
