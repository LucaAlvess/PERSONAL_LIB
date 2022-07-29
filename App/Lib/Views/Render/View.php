<?php

namespace App\Lib\Views\Render;

/**
 * Classe responsável por gerenciar o conteúdo das views
 */
class View
{
    /**
     * Método responsável por caputurar o conteúdo da View
     * @param string $viewName [pasta/view]
     * @param string $extension extensão do arquivo
     * @return string
     */
    private static function getContentView(string $viewName, string $extension = 'html'): string
    {
        $file = __DIR__ . "/../../../Views/{$viewName}.{$extension}";
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Método responsável por renderizar as variáveis da View
     * @param string $viewName [pasta/view]
     * @param array $vars Variáveis a serem substituídas
     * @return string
     */
    public static function render(string $viewName, array $vars = []): string
    {
        $content = self::getContentView($viewName);
        $keys = array_keys($vars);

        $keys = array_map(function ($item) {
            return "{{" . $item . "}}";
        }, $keys);

        return str_replace($keys, array_values($vars), $content);
    }
}