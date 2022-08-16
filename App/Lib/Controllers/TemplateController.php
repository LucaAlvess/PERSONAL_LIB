<?php

namespace App\Lib\Controllers;

use App\Lib\Views\Render\View;

/**
 * Classe responsável por criar o template padrão para as páginas
 */
class TemplateController extends View
{
    /**
     * Método responsável por pegar o conteúdo do header
     * @return string
     */
    private static function getHeader(): string
    {
        return View::render('template/header');
    }

    /**
     * Método responsável por pegar o conteúdo do footer
     * @return string
     */
    private static function getFooter(): string
    {
        return View::render('template/footer');
    }

    /**
     * Método responsável por renderizar o template com o conteúdo
     * @param string $title Título da página
     * @param string $content Conteúdo da página
     * @return string
     */
    public static function getTemplate(string $title, string $content): string
    {
        return View::render('template/page', [
            'TITLE' => $title,
            'HEADER' => self::getHeader(),
            'CONTENT' => $content,
            'FOOTER' => self::getFooter()
        ]);
    }
}