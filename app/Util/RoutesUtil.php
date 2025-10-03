<?php

// Classe utilitária para processamento de rotas da aplicação
namespace Util;

class RoutesUtil
{
    // Retorna as rotas processadas da URL
    public static function getRoutes()
    {
        return self::getUrls();
    }

    // Processa URL removendo query strings e formatando como array
    public static function getUrls()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        // Remove query string
        $uri = explode('?', $uri)[0];
        // Remove barra inicial e final
        $uri = trim($uri, '/');
        // Retorna as partes da rota como array
        return explode('/', $uri);
    }
}
