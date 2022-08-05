<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . '/vendor/autoload.php';

use App\Lib\Controllers\Page;
use App\Lib\Utils\Error;

try {
    if (isset($_GET['url'])) {
        $class = NAMESPACE_CONTROLLER . Page::url()['className'];
        if (class_exists($class)) {
            $page = new $class;
            $page->show();
        } else {
            throw new Exception(PAGE_NOT_FOUND_MESSAGE, 404);
        }
    } else {
        $class = NAMESPACE_CONTROLLER . 'HomeController';
        if (class_exists($class)) {
            $page = new $class;
            $page->index();
        }
    }
} catch (\Exception $e) {
    $error = new Error($e);
    $error->render();
}