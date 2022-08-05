<?php

namespace App\Lib\Utils\LOG;

use App\Lib\Utils\LOG\Logger;

/**
 * Classe para gerenciar arquivos de LOG em TXT
 */
class LoggerTXT extends Logger
{

    /**
     * Método responsável por criar um arquivo de LOG com a mensagem
     * @param string $message
     * @return void
     */
    function write(string $message): void
    {
        $text = "\n".date('Y-m-d H:i:s') . ' : ' . $message;
        $handler = fopen($this->fileName, 'a');
        fwrite($handler,$text);
        fclose($handler);
    }
}