<?php


namespace Util;

class RoutesUtil
{
    /**
     * Retorna as rotas processadas da URL
     */
    public static function getRoutes()
    {
        return self::getUrls();
    }

    /**
     * Retorna a URL processada, removendo o diretório do projeto
     */
    public static function getUrls()
    {
        // Defina o nome do diretório do projeto conforme sua estrutura
        $dirProjeto = 'api-php';
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $uri = str_replace('/' . $dirProjeto, '', $uri);
        // Remove query string
        $uri = explode('?', $uri)[0];
        // Remove barra inicial e final
        $uri = trim($uri, '/');
        // Retorna as partes da rota como array
        return explode('/', $uri);
    }
}