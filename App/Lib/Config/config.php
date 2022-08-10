<?php

/**
 *
 * NAMESPACE CONTROLLER
 *
 */

const NAMESPACE_CONTROLLER = 'App\\Controllers\\';
const NAMESPACE_ENTITY = "App\\Models\\Entity\\";

/**
 *
 * URL
 *
 */

define("HTTP_HOST", $_SERVER['HTTP_HOST'] . '/');
define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);

/**
 *
 * MESSAGES ERROR
 *
 */

const PAGE_NOT_FOUND_MESSAGE = 'Página não encontrada :/';
const PAGE_ERROR_SERVER_MESSAGE = 'Erro com o servidor, estamos resolvendo isso :/';

/**
 *
 * E-MAIL
 *
 */

const EMAIL_HOST = 'smtp.office365.com';
const EMAIL_USER = 'lucas.dev.teste@hotmail.com';
const EMAIL_PASS = 'Lucas3765632514';
const EMAIL_SECURE = 'TLS';
const EMAIL_PORT = 587;
const EMAIL_CHARSET = 'utf-8';
const EMAIL_REMETENTE = 'lucas.dev.teste@hotmail.com';
const EMAIL_REMETENTE_NAME = 'Lucas brabo';

/**
 *
 * IMAGE CONFIG
 *
 */

const IMG_EXTENSIONS = [
    'jpg',
    'jpeg',
    'png',
    'gif'
];
const IMG_MAX_SIZE = 999999999999999999;

/**
 *
 * DATES
 *
 */

define("DATE_EXPIRATION_COOKIE", time() + 60 * 60 * 24 * 30);
