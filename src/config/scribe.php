<?php

use Knuckles\Scribe\Extracting\Strategies;
use Knuckles\Scribe\Config\Defaults;
use Knuckles\Scribe\Config\AuthIn;
use function Knuckles\Scribe\Config\{removeStrategies, configureStrategy};

return [

    /*
    |--------------------------------------------------------------------------
    | Informações básicas da API
    |--------------------------------------------------------------------------
    */
    'title' => 'Recrutamento API - Documentação',
    'description' => 'API para gestão de vagas, candidatos e inscrições.',
    'intro_text' => <<<INTRO
        Esta documentação descreve os endpoints disponíveis para o sistema de recrutamento.

        Você pode testar as chamadas diretamente pelo botão **Try It Out**.
    INTRO,

    // URL base usada nos exemplos (usa o APP_URL do .env)
    'base_url' => config('SCRIBE_BASE_URL', null) . '/api',

    /*
    |--------------------------------------------------------------------------
    | Rotas a serem documentadas
    |--------------------------------------------------------------------------
    */
    'routes' => [
        [
            'match' => [
                'prefixes' => ['api/*'], // só rotas da API
                'domains' => ['*'],
            ],
            'include' => [],
            'exclude' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tipo de saída
    |--------------------------------------------------------------------------
    */
    'type' => 'laravel', // docs disponíveis via rota /docs
    'theme' => 'default',

    'laravel' => [
        'add_routes' => true,
        'docs_url' => '/docs', // acessa em http://localhost:8000/docs
        'assets_directory' => null,
        'middleware' => [], // aqui você poderia proteger a doc ex: ['auth']
    ],

    /*
    |--------------------------------------------------------------------------
    | Try It Out (teste no navegador)
    |--------------------------------------------------------------------------
    */
    'try_it_out' => [
        'enabled' => true,
        'base_url' => null, // null = usa base_url acima
        'use_csrf' => false,
        'csrf_url' => '/sanctum/csrf-cookie',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autenticação
    |--------------------------------------------------------------------------
    */
    'auth' => [
        'enabled' => false, // por enquanto sem auth
        'default' => false,
        'in' => AuthIn::BEARER->value,
        'name' => 'Authorization',
        'use_value' => env('SCRIBE_AUTH_KEY'),
        'placeholder' => 'Bearer {YOUR_AUTH_KEY}',
        'extra_info' => 'Adicione o token no campo Authorization como: Bearer {token}.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Linguagens exemplo
    |--------------------------------------------------------------------------
    */
    'example_languages' => [
        'bash',
        'javascript',
        'php',
        'python',
    ],

    /*
    |--------------------------------------------------------------------------
    | Saídas extras
    |--------------------------------------------------------------------------
    */
    'postman' => [
        'enabled' => true,
        'overrides' => [],
    ],

    'openapi' => [
        'enabled' => true,
        'overrides' => [],
        'generators' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Organização dos grupos
    |--------------------------------------------------------------------------
    */
    'groups' => [
        'default' => 'Endpoints',
        'order' => [
            'Vagas',
            'Candidatos',
            'Inscrições',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Outras configs
    |--------------------------------------------------------------------------
    */
    'logo' => false,
    'last_updated' => 'Última atualização: {date:d/m/Y H:i}',

    'examples' => [
        'faker_seed' => 1234,
        'models_source' => ['factoryCreate', 'factoryMake', 'databaseFirst'],
    ],

    'strategies' => [
        'metadata' => [...Defaults::METADATA_STRATEGIES],
        'headers' => [
            ...Defaults::HEADERS_STRATEGIES,
            Strategies\StaticData::withSettings(data: [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]),
        ],
        'urlParameters' => [...Defaults::URL_PARAMETERS_STRATEGIES],
        'queryParameters' => [...Defaults::QUERY_PARAMETERS_STRATEGIES],
        'bodyParameters' => [...Defaults::BODY_PARAMETERS_STRATEGIES],
        'responses' => configureStrategy(
            Defaults::RESPONSES_STRATEGIES,
            Strategies\Responses\ResponseCalls::withSettings(
                only: ['GET *'],
                config: ['app.debug' => false]
            )
        ),
        'responseFields' => [...Defaults::RESPONSE_FIELDS_STRATEGIES],
    ],

    'database_connections_to_transact' => [config('database.default')],
    'fractal' => ['serializer' => null],
];
