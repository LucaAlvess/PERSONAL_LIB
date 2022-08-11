<?php

namespace App\Lib\Utils;

/**
 *
 */
class Cookie
{
    /***Propriedade que armazena o nome do parâmetro do cookie @var string $nameCookieParam*/
    private static string $nameCookieParam = 'user';

    /**
     * @param string $cookieValue
     * @param string|int|null $nameCookieParam
     * @return void
     */
    public static function createCookie(string $cookieValue, string|int|null $nameCookieParam = null): void
    {
        if($nameCookieParam) self::$nameCookieParam = $nameCookieParam;

        setcookie(self::$nameCookieParam, $cookieValue, DATE_EXPIRATION_COOKIE);
    }

    /**
     * Método responsável por retornar o valor do cookie
     * @return string|int
     */
    public static function returnValueCookie(): string|int
    {
        return $_COOKIE[self::$nameCookieParam];
    }

    /**
     * Método responsável por verificar se existe um valor armazenado no cookie
     * @return bool
     */
    public static function checkIfCookieExist(): bool
    {
        if (isset($_COOKIE[self::$nameCookieParam])) return true;

        return false;
    }

    /**
     * Metodo responsável por finalizar os cookies
     * @return void
     */
    public static function eatCookie(): void
    {
        unset($_COOKIE[self::$nameCookieParam]);
        setcookie(self::$nameCookieParam, '');
    }
}