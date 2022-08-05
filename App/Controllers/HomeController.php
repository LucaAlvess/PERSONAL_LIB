<?php

namespace App\Controllers;

use App\Controllers\Template\TemplateController;
use App\Lib\Controllers\Page;
use App\Lib\Views\Render\View;
use Exception;

/**
 * Classe controladora para a home
 */
class HomeController extends Page
{
    /**
     * Exibe o conteúdo de Home
     * @throws Exception
     * @return  void
     */
    public function index(): void
    {
        try {
            $content = View::render('home/home');
            echo TemplateController::getTemplate('Página Inicial', $content);
        } catch (Exception $e) {
            throw new Exception(PAGE_ERROR_SERVER_MESSAGE, 500);
        }
    }
}