<?php

namespace app\Models;

use PDO;

class Recipe
{
    /**
     * Возвращаем список всех рецептов из базы данных
     *
     * @return false|array
     */
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
     * Ищем рецепт в базе данных по слагу
     *
     * @param string $slug Уникальный slug рецепта
     * @return array|null
     */
    public static function findBySlug(string $slug): ?array
    {
        $db = self::getDB();
        $stmt = $db->prepare('SELECT * FROM recipes WHERE slug = :slug');
        $stmt->execute([':slug' => $slug]);
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        return $recipe ?: null;
    }

    /**
     * @param string $slug
     * @param string $title
     * @param string $ingredients
     * @param string $instructions
     * @param string|null $imagePath
     * @return bool
     */
    public static function update(string $slug, string $title, string $ingredients, string $instructions, ?string $imagePath): bool
    {
        $db = self::getDB();
        $query = 'UPDATE recipes SET title = :title, ingredients = :ingredients, instructions = :instructions';

        if ($imagePath) {
            $query .= ', image_path = :image_path';
        }

        $query .= ' WHERE slug = :slug';

        $stmt = $db->prepare($query);
        $params = [
            ':title' => $title,
            ':ingredients' => $ingredients,
            ':instructions' => $instructions,
            ':slug' => $slug,
        ];

        if ($imagePath) {
            $params[':image_path'] = $imagePath;
        }

        return $stmt->execute($params);
    }

    /**
     * @param string $slug
     * @return bool
     */
    public static function deleteBySlug(string $slug): bool
    {
        $db = self::getDB();
        $stmt = $db->prepare("DELETE FROM recipes WHERE slug = :slug");
        $stmt->bindParam(':slug', $slug);

        return $stmt->execute();
    }

    /**
     * Подключение к базе данных
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
