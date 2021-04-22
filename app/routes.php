<?php

// ROUTES
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    // Index page
    $r->addRoute('GET', '/', ['DecodeInterface', 'getPage']);

    // Menu
    $r->addRoute('GET', '/menu', ['DecodeInterface', 'getMenu']);

    // Preview all?
    $r->addRoute('GET', '/preview', ['DecodeInterface', 'getPreview']);

    // Save to table
    $r->addRoute('GET', '/parse', ['DecodeInterface', 'getPreviewAll']);

    // Preview object with ID ..
    $r->addRoute('GET', '/preview/{id:\d+}', ['DecodeInterface', 'getPreview']);

    // Index in tables
    $r->addRoute('GET', '/index', ['ObjectIndexer', 'index']);

    // JSON object data
    $r->addRoute('GET', '/data/object', ['DecodeInterface', 'getObjects']);

    // JSON all data
    $r->addRoute('GET', '/data/{type}', ['DecodeInterface', 'getData']);

});



// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "Not found!";
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;

    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $className = 'App\\'. $handler[0];
        $function = $handler[1];

        echo (new $className())->{$function}($vars);
        // echo (new $className($vars))->{$function}();

        break;
}

function dd($var) {
    var_dump($var); exit;
}
