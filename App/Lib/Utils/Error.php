<?php

namespace App\Lib\Utils;

use App\Lib\Views\Render\View;
use App\Controllers\Template\TemplateController;
use Exception;

/**
 * Classe responsável por gerenciar os erros da aplicaçao
 */
class Error
{
    /*** Propriedade que armazena a mensagem de erro @var string $message */
    private string $message;

    /*** Propriedade que armazena o código de erro @var int $code */
    private int $code;

    /**
     * Construtor da classe que captura a mensagem e código de erro nas exceções
     * @param Exception $exception
     */
    public function __construct(Exception $exception)
    {
        $this->code = $exception->getCode();
        $this->message = $exception->getMessage();
    }

    /**
     * @return int
     */
    private function getErrorCode(): int
    {
        return $this->code;
    }

    /**
     * Método responsável por retornar a mensagem de erro
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Método responsável por retornar o código de erro
     * @return void
     */
    public function render(): void
    {
        $content = View::render("errors/{$this->getErrorCode()}", [
            'ERROR' => $this->getMessage() . '  ' . $this->getErrorCode()
        ]);

        echo TemplateController::getTemplate("Erro - {$this->getErrorCode()}", $content);
    }
}