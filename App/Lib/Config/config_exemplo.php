<?php

/**
 *
 * NAMESPACE CONTROLLER
 *
 */

const NAMESPACE_CONTROLLER = 'App\\Controllers\\';

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

const EMAIL_HOST = '';
const EMAIL_USER = '';
const EMAIL_PASS = '';
const EMAIL_SECURE = 'TLS';
const EMAIL_PORT = 587;
const EMAIL_CHARSET = 'utf-8';
const EMAIL_REMETENTE = '';
const EMAIL_REMETENTE_NAME = 'Neymar Jr';