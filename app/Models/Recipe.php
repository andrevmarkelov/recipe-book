<?php

namespace app\Models;

use PDO;

class Recipe
{
    public static function index(): false|array
    {
        $db = self::getDB();
        $stmt = $db->query('SELECT * FROM recipes ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Сохранение рецепта в базу данных
     *
     * @param string $title Название рецепта
     * @param string $slug Уникальный slug рецепта
     * @param string $ingredients Ингредиенты
     * @param string $instructions Инструкция
     * @param string $imagePath Путь до изображения
     * @return void
     */
    public static function store(string $title, string $slug, string $ingredients, string $instructions, string $imagePath): void
    {
        $db = self::getDB();
        $stmt = $db->prepare('
            INSERT INTO recipes (title, slug, ingredients, instructions, image_path) 
            VALUES (:title, :slug, :ingredients, :instructions, :image_path)
        ');

        $stmt->execute([
            ':title' => $title,
            ':slug' => $slug,
            ':ingredients' => $ingredients,
            ':instructions' => $instructions,
            ':image_path' => $imagePath,
        ]);
    }

    /**
     * Получение подключения к базе данных
     *
     * @return PDO
     */
    private static function getDB(): PDO
    {
        $config = include __DIR__ . '/../../config/database.php';

        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";
        return new PDO($dsn, $config['username'], $config['password']);
    }
}