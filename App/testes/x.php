<?php

require_once __DIR__ . '/../../vendor/autoload.php';

session_start();

use App\Lib\Utils\Session;
use App\Lib\Utils\Cookie;

if(Cookie::checkIfCookieExist()) Session::createSession(Cookie::returnValueCookie());

@$nome = $_POST['nome'];
@$senha = $_POST['senha'];

@var_dump($_POST);
@var_dump($_COOKIE);
@var_dump($_SESSION);

if(isset($_POST['nome'])) {
    $user = [
        "nome" => 'lucas',
        'senha' => '123'
    ];

    if($nome == $user['nome'] && $senha == $user['senha']) {
        Session::createSession($nome);
        Cookie::createCookie($nome);
        header('Location: saudacao.php');
    }
}

include __DIR__ . '/form.php';
