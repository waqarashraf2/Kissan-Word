<?php

$publicPath = __DIR__;
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
$requestedPath = $publicPath.$uri;

// Serve real assets directly, but let Laravel handle routes that share a
// name with public directories, such as /products.
if ($uri !== '/' && is_file($requestedPath)) {
    return false;
}

require $publicPath.'/index.php';
