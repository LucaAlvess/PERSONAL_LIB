<?php

session_start();
require_once __DIR__ .'/../../vendor/autoload.php';

@var_dump($_COOKIE);
@var_dump($_SESSION);


use App\Lib\Utils\Cookie;
use App\Lib\Utils\Session;

if(!isset($_SESSION['user'])) {
    header('Location: http://localhost/App/testes/x.php');
}

echo 'Área restrita';

session_destroy();
Cookie::eatCookie();
Cookie::createCookie('');