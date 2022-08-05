<?php

/**
 *
 *  CONTROLLERS
 *
 */

/**
 * Função para tratar o nome da classe dos controladores
 * @param string $className
 * @return string|false
 */
function formatClassNameController(string $className): string|false
{
    if (!empty($className)) {
        return trim(ucfirst(strtolower($className))) . 'Controller';
    }
    return false;
}

/**
 * Função para tratar o nome dos métodos dos controladores
 * @param string $methodName
 * @return string|false
 */
function formatMethodNameController(string $methodName): string|false
{
    if (!empty($methodName)) {
        return trim(strtolower($methodName));
    }
    return false;
}