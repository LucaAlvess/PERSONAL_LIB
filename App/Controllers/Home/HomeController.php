<?php

namespace App\Controllers\Home;

use App\Lib\Controllers\TemplateController;
use App\Lib\Views\Render\View;

/**
 * Classe controladora para a home
 */
class HomeController extends TemplateController
{
    /**
     * Exibe o conteúdo de Home
     */
    public function __construct()
    {
        $content = View::render('home/home');

        echo TemplateController::getTemplate('Página Inicial', $content);
    }
}