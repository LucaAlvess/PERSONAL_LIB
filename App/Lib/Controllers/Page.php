<?php

namespace App\Lib\Controllers;

use Exception;
use JetBrains\PhpStorm\NoReturn;

/**
 * Super classe com o método comum para todos os controladores
 */
class Page
{
    /*** Armazena a query string da requisição @var array $queryParams */
    private static array $queryParams;

    /**
     * Método responsável por chamar o método da classe de controler
     * @return void
     * @throws Exception
     */
    public function show(): void
    {
        if (isset(self::url()['methodName'])) {
            $method = self::url()['methodName'];
            if (method_exists($this, $method)) {
                call_user_func([$this, $method], $_REQUEST);
            } else {
                throw new Exception(PAGE_NOT_FOUND_MESSAGE, 404);
            }
        }
    }

    /**
     * Método responsável por fazer o redirecionamento de página
     * @param string $viewName [pasta/nomeView]
     * @return void
     */
    #[NoReturn] protected function redirect(string $viewName): void
    {
        header('Location: http://' . HTTP_HOST . $viewName);
        exit;
    }

    /**
     * Método responsável por capturar e retornar a query string com o nome da classe(controler)
     * e nome do método tratada
     * @return array|null
     */
    public static function url(): array|null
    {
        if (isset($_GET['url'])) {
            $get = explode('/', $_GET['url']);

            if (isset($get[0])) {
                self::$queryParams = [
                    'className' => formatClassNameController($get[0]),
                ];
            }

            if (isset($get[1])) {
                self::$queryParams['methodName'] = formatMethodNameController($get[1]);
            }

            if (isset($get[2])) {
                self::$queryParams['postVar'] = $get[2];
            }

            return self::$queryParams;
        }
        return null;
    }

    protected function getUrlParam()
    {
        $param = self::url();

        return $param['postVar'];
    }
}