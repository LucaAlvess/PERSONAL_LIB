<?php

namespace App\Lib\Utils\LOG;

/**
 * Classe responsável por gerenciar os arquivos de log
 */
abstract class Logger
{
    /*** Propriedade que armazena o nome do arquivo de LOG @var string */
    protected string $fileName;

    /**
     * Construtor da classe responsável por armazenar o nome do arquivo de LOG
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Método responsável por escrever o conteúdo no arquivo
     * @param string $message Mensagem que será armazenada
     * @return void
     */
    abstract function write(string $message): void;
}