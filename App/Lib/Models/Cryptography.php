<?php

namespace App\Lib\Models;

/**
 * Classe responsável por criptografar e descriptografar dados
 */
class Cryptography
{

    const KEY = 'juju78"&*%$==';

    /**
     * Método responsável por criptografar dados(senha)
     * @param string $data Dado(senha) a ser criptografada
     * @return string
     */
    public static function encryptPassword(string $data): string
    {
        return password_hash($data, PASSWORD_DEFAULT);
    }

    /**
     * Mpetodo responsável por verificar a igualdade do dado(senha) com um hash
     * @param string $password Dado(senha) a ser comparado com o hash
     * @param string $hash Hash a ser comparado com o dado(senha)
     * @return bool
     */
    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Método responsável por criar uma criptografia de um dado
     * @param string $text string a ser criptografada
     * @return string
     */
    public static function encryptHash(string $text): string
    {
        if (empty($text)) {
            return '';
        }

        return base64_encode($text . self::KEY);
    }

    /**
     * Método responsável por descriptografar um token
     * @param string $token
     * @return string
     */
    public static function decryptHash(string $token): string
    {
        $text = base64_decode($token);

        return str_replace(self::KEY, '', $text);
    }
}