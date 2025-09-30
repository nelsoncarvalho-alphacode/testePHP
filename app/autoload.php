<?php


/**
 * Função de autoload para carregar automaticamente as classes do projeto.
 * Isso evita a necessidade de usar require/include manualmente para cada classe.
 * O padrão utilizado é buscar as classes dentro da pasta 'Classes',
 * convertendo o namespace em caminho de diretório.
 */

function autoload($class)
{
    // Monta o caminho base do projeto usando a constante DIR_APP e o separador de diretório
    $baseDirectory = DIR_APP.DS;

    // Monta o caminho completo do arquivo da classe:
    // - Adiciona a pasta 'Classes/'
    // - Substitui as barras invertidas do namespace por separadores de diretório
    // - Adiciona a extensão .php
    $class = $baseDirectory.'Classes'.DS.str_replace('\\', DS, $class).'.php';

    // Se o arquivo existir e não for um diretório, inclui o arquivo (carrega a classe)
    if (file_exists($class) && !is_dir($class)) {
        include $class;
    }
}

// Registra a função de autoload para ser chamada automaticamente
// sempre que uma classe for usada e ainda não estiver carregada
spl_autoload_register('autoload');