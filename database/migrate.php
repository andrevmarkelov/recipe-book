<?php

require_once __DIR__ . '/../config/db_connect.php';

foreach (glob(__DIR__ . '/migrations/*.sql') as $migrationFile) {
    try {
        $query = file_get_contents($migrationFile);
        $db->exec($query);
        echo 'Миграция выполнена: ' . basename($migrationFile) . PHP_EOL;
    } catch (PDOException $e) {
        echo 'Ошибка выполнения миграции ' . basename($migrationFile) . ": " . $e->getMessage() . PHP_EOL;
    }
}
