<?php

namespace app\Helpers;

class Validation
{
    public static function validateRecipe($data, $files): array
    {
        $errors = [];

        if (empty($data['title'])) {
            $errors['title'] = 'Название рецепта обязательно для заполнения.';
        } else if (strlen($data['title']) < 3 || strlen($data['title']) > 255) {
            $errors['title'] = 'Название должно содержать от 3 до 255 символов.';
        }

        if (empty($data['slug'])) {
            $errors['slug'] = 'Slug обязателен для заполнения.';
        } else if (!preg_match('/^[a-z0-9-]+$/', $data['slug'])) {
            $errors['slug'] = 'Slug может содержать только буквы, цифры и дефисы.';
        }

        if (empty($data['ingredients'])) {
            $errors['ingredients'] = 'Поле "Ингредиенты" не может быть пустым.';
        } else if (strlen($data['ingredients']) < 10) {
            $errors['ingredients'] = 'Поле "Ингредиенты" должно содержать минимум 10 символов.';
        }

        if (empty($data['instructions'])) {
            $errors['instructions'] = 'Поле "Инструкция" не может быть пустым.';
        } else if (strlen($data['instructions']) < 10) {
            $errors['instructions'] = 'Инструкция должна быть длиной не менее 10 символов.';
        }

        if (empty($files['image']['name'])) {
            $errors['image'] = 'Изображение обязательно для загрузки.';
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($files['image']['type'], $allowedTypes)) {
                $errors['image'] = 'Изображение должно быть формата JPG, PNG или GIF.';
            }
            if ($files['image']['size'] > 5 * 1024 * 1024) {
                $errors['image'] = 'Размер изображения не должен превышать 5 МБ.';
            }
        }

        return $errors;
    }
}
