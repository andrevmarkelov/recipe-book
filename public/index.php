<?php

require_once __DIR__ . '/../app/Controllers/RecipeController.php';

$routes = require_once __DIR__ . '/../routes/web.php';

$requestUri = strtok($_SERVER['REQUEST_URI'], '?');
$method = $_SERVER['REQUEST_METHOD'];

if (array_key_exists($requestUri, $routes) && $method === 'GET') {
    $routes[$requestUri]();
} else {
    header('HTTP/1.0 404 Not Found');
    echo 'Страница не найдена.';
}