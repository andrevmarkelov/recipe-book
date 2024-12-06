<?php

require_once __DIR__ . '/../app/Controllers/RecipeController.php';

$routes = require_once __DIR__ . '/../routes/web.php';

$requestUri = strtok($_SERVER['REQUEST_URI'], '?');
$method = $_SERVER['REQUEST_METHOD'];

if (array_key_exists($requestUri, $routes)) {
    if ($method === 'POST' || $method === 'GET') {
        $routes[$requestUri]();
    } else {
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode(['status' => 'error', 'message' => 'Метод не разрешён']);
    }
} else {
    header('HTTP/1.0 404 Not Found');
    echo json_encode(['status' => 'error', 'message' => 'Страница не найдена']);
}