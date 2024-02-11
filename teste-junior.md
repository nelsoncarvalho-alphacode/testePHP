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
- Criei a pasta Repositories dentro de App


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






## Falta fazer 
  - Deve ser filtrável e ordenável por qualquer campo, e possuir paginação de 20 itens.

## Bônus
- Permitir deleção em massa de itens nos CRUDs.
- Permitir que o usuário mude o número de itens por página.

## O que iremos analisar

- Organização do código;
- Conhecimento de padrões (PSRs, design patterns, SOLID);
- Separação de módulos e componentes;
- Legibilidade;
- Tratamento de erros;

### Boa sorte!