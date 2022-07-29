<?php

namespace App\Lib\Connection;

use App\Lib\Connection\Connect;
use PDO;
use Exception;

/**
 * Classe para transação
 */
class Transaction
{
    /*** Propriedade que armazena a instância de PDO com a conexão@var PDO|null $conn */
    private static PDO|null $conn;

    /*** Propriedade que armazena a instância da classe de Logger @var Logger|null $logger */
    private static Logger|null $logger;

    /**
     * Método responsável por abrir uma transação com a conexão
     * @param string $conn Nome do arquivo contendo as configurações da conexão
     * @return void
     * @throws Exception
     */
    public static function open(string $conn): void
    {
        self::$conn = Connect::getConnection($conn);
        self::$conn->beginTransaction();
        self::$logger = null;
    }

    /**
     * Método responsável por fechar a transação finalizando-a
     * @return void
     */
    public static function close(): void
    {
        if (self::$conn) {
            self::$conn->commit();
            self::$conn = null;
        }
    }

    /**
     * Método responsável por retornar a conexão com transação
     * @return PDO
     */
    public static function get(): PDO
    {
        return self::$conn;
    }

    /**
     * Método responsável por desfazer a transação com a base de dados
     * @return void
     */
    public static function rollback(): void
    {
        if (self::$conn) {
            self::$conn->rollBack();
            self::$conn = null;
        }
    }

    /**
     * Método responsável por setar qual o método de log será chamado
     * @param Logger $logger
     * @return void
     */
    public static function setLogger(Logger $logger): void
    {
        self::$logger = $logger;
    }

    /**
     * Método responsável por escrever a mensagem de LOG
     * @param string $message Mensagem que será gravada no arquivo de LOG
     * @return void
     */
    public static function log(string $message): void
    {
        if (self::$logger) {
            self::$logger->write($message);
        }
    }

    /**
     * Construtor declarado como privado para impedir a instância da classe
     */
    private function __construct()
    {
    }
}