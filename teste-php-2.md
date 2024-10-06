Olá pessoal da Alphacode, espero que estejam bem!

[[Demosntração da aplicação no Youtube]](https://www.youtube.com/watch?v=n7xbOdmfEak)

# Requisitos da aplicação:

* PHP 8.1
* MySQL 8.0
* Servidor Apache e MySQL

# Intruções para rodar a aplicação com o Docker:

* Baixe o código da aplicação
* Se optar rodar o ambiente de desenvolvimento com o Docker, rode comando:

`` docker-compose up -d --build ``

* No container da aplicação:

* Rode o comando para rodar as migrations:

`` php artisan migrate ``

* Rode o comando para execução das seeds:

`` php artisan db:seed --class=TiposContrato ``


* E no container MySQL, crie um banco de dados chamado: "candidatos_empregos"

# Instruções para rodar a aplicação manualmente:

* Baixe o código da aplicação
* Rode o comando para instalação das dependências:

`` composer install ``

* Ligue o servidor MySQL e crie um banco de dados chamado: "candidatos_empregos"
* Rode o comando para rodar as migrations:

`` php artisan migrate ``

* Rode o comando para execução das seeds:

`` php artisan db:seed --class=TiposContrato ``

* Rode o comando para rodar o servidor Laravel:

`` php artisan serve ``


# Teste para candidatos à vaga de Desenvolvedor PHP

Olá caro desenvolvedor, nesse teste analisaremos seu conhecimento geral e inclusive velocidade de desenvolvimento. Abaixo explicaremos tudo o que será necessário.

## Instruções

O desafio consiste em implementar uma aplicação web utilizando PHP, um banco de dados relacional (Mysql, Postgres ou SQLite), que terá como finalidade a inscrição de candidatos a uma oportunidade de emprego.

Sua aplicação deve possuir:

- CRUD de vagas:
  - Criar, editar, excluir e listar vagas.
  - A vaga pode ser CLT, Pessoa Jurídica ou Freelancer.
- CRUD de candidatos:
  - Criar, editar, excluir e listar candidatos.
- Um cadidato pode se inscrever em uma ou mais vagas.
- Deve ser ser possível "pausar" a vaga, evitando a inscrição de candidatos.
- Cada CRUD:
  - Deve ser filtrável e ordenável por qualquer campo, e possuir paginação de 20 itens.
  - Deve possuir formulários para criação e atualização de seus itens.
  - Deve permitir a deleção de qualquer item de sua lista.
  - Implementar validações de campos obrigatórios e tipos de dados.

## Banco de dados

- Você pode criar a modelagem e implementar as validações necessárias da camada da forma que julgar melhor.

## Tecnologias a serem utilizadas

Devem ser utilizadas as seguintes tecnologias:

- HTML
- CSS
- Javascript
- PHP (Framework Opcional: Laravel, CodeIgnither)
- Docker (construção do ambiente de desenvolvimento)
- Mysql, Postgres ou SQLite

## Entrega

- Para iniciar o teste, faça um fork deste repositório; **Se você apenas clonar o repositório não vai conseguir fazer push.**
- Crie uma branch com o seu nome completo;
- Altere o arquivo teste-php.md com as informações necessárias para executar o seu teste (comandos, instalações, etc);
- Depois de finalizado, envie-nos o pull request;

## Bônus

- API Rest JSON para todos os CRUDS listados acima.
- Permitir deleção em massa de itens nos CRUDs.
- Permitir que o usuário mude o número de itens por página.
- Implementar autenticação de usuário na aplicação.

## O que iremos analisar

- Organização do código;
- Conhecimento de padrões (PSRs, design patterns, SOLID);
- Separação de módulos e componentes;
- Legibilidade;
- Tratamento de erros;

### Boa sorte!
