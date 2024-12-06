<?php

require_once __DIR__ . '/../app/Controllers/RecipeController.php';

$routes = require_once __DIR__ . '/../routes/web.php';

$requestUri = strtok($_SERVER['REQUEST_URI'], '?');
$method = $_SERVER['REQUEST_METHOD'];

$routeMatched = false;

if (array_key_exists($requestUri, $routes)) {
    $routeMatched = true;
    $routes[$requestUri]();
} else {
    foreach ($routes as $route => $handler) {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
        $pattern = "#^" . $pattern . "$#";

        if (preg_match($pattern, $requestUri, $matches)) {
            array_shift($matches);
            $routeMatched = true;
            $handler(...$matches);
            break;
        }
    }
}

if (!$routeMatched) {
    header('HTTP/1.0 404 Not Found');
    include __DIR__ . '/../app/Views/errors/404.php';
}
