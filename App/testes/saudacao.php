<?php

session_start();

require_once __DIR__ .'/../../vendor/autoload.php';

use App\Lib\Utils\Cookie;
use App\Lib\Utils\Session;

if(Cookie::checkIfCookieExist()) Session::createSession(Cookie::returnValueCookie());

@var_dump($_COOKIE);
@var_dump($_SESSION);

?>

<h1>Saudação</h1>
<a href="restrita.php">Área restrita</a>