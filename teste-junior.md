# Informações

Olá caro desenvolvedor, nesse teste analisaremos seu conhecimento geral e inclusive velocidade de desenvolvimento. Abaixo explicaremos tudo o que será necessário.

### Tecnologias
Node 18.17.1
PHP 8.2
Laravel 10
Vue 3
Bootstrap 5
MySQL

## Comandos Iniciais
- composer create-project laravel/laravel orders_app
- cd orders_app
- php artisan key:generate
- php artisan serve


## Migrations
- php artisan migrate


## Controllers
- php artisan make:controller ProductController --resource
- php artisan make:controller ClientController --resource
- php artisan make:controller OrderController --resource

yvvty
xx

## Models e Migrations
- php artisan make:model Client -m
- php artisan make:model Product -m
- php artisan make:model Order -m
- php artisan make:model OrderItem -m


## Requests
- php artisan make:request ClientRequest
- php artisan make:request ProductRequest
- php artisan make:request OrderRequest


## Repositories
- Repositories criado dentro de App


## Instalações
- composer require jwt-auth
- composer require laravel\ui
- npm install pinia


## Gerando o esqueleto do projeto com VueJS e autenticação nativa(scaffold)
- php artisan ui vue --auth

## Baixar dependências de front-end
- npm install

## Produzindo o bundle de front
- npm run dev


## Construindo ambiente (Docker)
- php artisan sail:install
- php artisan sail:publish
- No arquivo docker-compose.yml:
    -  Porta do container laravel.test alterada para 8001, apontando para porta 80 local
- docker compose build (Constrói o container e images)
- ./vendor/bin/sail up (Sobe o container)
- docker ps (Verifica se o container está ativo)
- docker exec -it <id_do_container> /bin/bash (Acessa o shell interativo do container cujo ID foi informado)
- sudo chmod -R 777 storage (Comando para corrigir o erro de Permission danied no navegador)
- php artisan migrate (cria as tabelas no banco de dados)
- npm run dev (start frontend)