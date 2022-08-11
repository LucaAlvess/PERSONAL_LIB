<?php

namespace App\Lib\Utils;

/**
 * Classe para gerenciar Sessões
 */
class Session
{

    private static string $sessionParamName = 'user';

    /**
     * Método responsável por gravar uma mensagem na variável de sessão
     * @param string $message
     * @return void
     */
    public static function recordMessage(string $message): void
    {
        $_SESSION['message'] = $message;
    }

    /**
     * Método responsável por deletar a mensagem na variável da sessão
     * @return void
     */
    public static function clearMessage(): void
    {
        unset($_SESSION['message']);
    }

    /**
     * Método responsável por retornar o valor da mensagem armazenada na variável da sessão
     * @return string
     */
    public static function returnMessageValue(): string
    {
        return $_SESSION['message'] ?? '';
    }

    /**
     * Método responsável por gravar o formulário na variável da sessão
     * @param array $form
     * @return void
     */
    public static function recordForm(array $form): void
    {
        $_SESSION['form'] = $form;
    }

    /**
     * Método responsável por deletar a mensagem na variável da sessão
     * @return void
     */
    public static function clearForm(): void
    {
        unset($_SESSION['form']);
    }

    /**
     * Método responsável por retornar o valor armazenado na variável da sessão
     * @param string|int|float $key
     * @return string
     */
    public static function returnFormValue(string|int|float $key): string
    {
        return $_SESSION['form'][$key] ?? '';
    }

    /**
     * Método responsável por retornar todos os valores armazenados na variável de sessão caso exista
     * @return string
     */
    public static function formExist(): string
    {
        return $_SESSION['form'] ?? '';
    }

    /**
     * Método responsável por armazenar o nome do usuario na sessão
     * @param string $valueSession
     * @param string|null $paramSession
     * @return void
     */
    public static function createSession(string $valueSession, string|null $paramSession = null): void
    {
        if ($paramSession) {
            self::$sessionParamName = $paramSession;
        }

        $_SESSION[self::$sessionParamName] = $valueSession;
    }

    /**
     * Método responsável por retornar o valor de um índice armazenado na sessão
     * @return bool|string
     */
    public static function returnSessionParam(): bool|string
    {
        if(isset($_SESSION[self::$sessionParamName])) {
            return $_SESSION[self::$sessionParamName];
        }

        return false;
    }

    /**
     * Método responsável por checar a existência do parâmetro na sessão
     * @return bool
     */
    public static function checkSession(): bool
    {
        if(isset($_SESSION[self::$sessionParamName])) return true;

        return false;
    }
}