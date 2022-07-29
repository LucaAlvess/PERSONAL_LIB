<?php

namespace App\Lib\Connection;

use PDO;
use Exception;

/**
 * Classe responsável por estabelecer a conexão com a base de dados
 */
class Connect
{
    /*** Propriedade que armazena a instância de PDO @var PDO $conn */
    private static PDO $conn;


    /**
     * Método responsável por retornar a conexão com a base de dados
     * @param string $fileName nome do arquivo ini de configuração sem a extensão
     * @return PDO
     * @throws Exception
     */
    public static function getConnection(string $fileName): PDO
    {
        $settings = self::getConfig($fileName);

        $drive = $settings['drive'] ?? null;
        $host = $settings['host'] ?? null;
        $port = $settings['port'] ?? null;
        $dbname = $settings['dbname'] ?? null;
        $user = $settings['user'] ?? null;
        $pass = $settings['pass'] ?? null;

        switch ($drive) {
            case 'mysql':
                $port = $settings['port'] ?? '3306';
                self::$conn = new PDO(
                    "mysql:host={$host};port={$port};dbname={$dbname}", $user, $pass
                );
                break;
        }
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$conn;
    }

    /**
     * Método responsável por retornar os valores do arquivo ini
     * @param string $fileName nome do arquivo ini de configuração sem a extensão
     * @return array
     * @throws Exception
     */
    private static function getConfig(string $fileName): array
    {
        if (file_exists(__DIR__ . "/../Config/{$fileName}.ini")) {
            $settings = parse_ini_file(__DIR__ . "/../Config/{$fileName}.ini");
        } else {
            throw new Exception("Arquivo {$fileName} não encontrado.");
        }

        return $settings;
    }

    /**
     * Método privado para garantir que a classe não seja instânciada
     */
    private function __construct()
    {
    }

    /**
     * Método responsável para garantir que classe não tenha clone de objeto
     * @return void
     */
    private function __clone(): void
    {
    }
}