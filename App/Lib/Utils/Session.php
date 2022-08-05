<?php

namespace App\Lib\Utils;

/**
 * Classe para gerenciar Sessões
 */
class Session
{
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
}