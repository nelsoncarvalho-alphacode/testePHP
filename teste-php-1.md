# Teste para candidatos à vaga de Desenvolvedor PHP

Olá caro desenvolvedor, nesse teste analisaremos seu conhecimento geral e inclusive velocidade de desenvolvimento. Abaixo explicaremos tudo o que será necessário.

## Instruções

O desafio consiste em implementar uma aplicação Web utilizando o PHP, e um banco de dados relacional SQLite, MySQL ou Postgres, a partir de uma modelagem de dados inicial desnormalizada, que deve ser normalizada para a implementação da solução.

Você vai criar uma aplicação de cadastro de pedidos de compra, a partir de uma modelagem inicial, com as seguintes funcionalidades:

- CRUD de clientes. (OK)
- CRUD de produtos. (OK)
- CRUD de pedidos de compra, com status (Em Aberto, Pago ou Cancelado).
- Cada CRUD:
  - deve ser filtrável e ordenável por qualquer campo, e possuir paginação de 20 itens. (OK)
  - deve possuir formulários para criação e atualização de seus itens. (OK)
  - deve permitir a deleção de qualquer item de sua lista. (OK)
- Barra de navegação entre os CRUDs. (OK)
- Links para os outros CRUDs nas listagens (Ex: link para o detalhe do cliente da compra na lista de pedidos de compra)

## Modelo de dados

A modelagem inicial para a implementação solução é a seguinte:

![](./images/modelo.png)

- Você deve alterar esta modelagem para que a mesma cumpra com as três primeiras formas normais.

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
- Altere o arquivo teste-junior.md com as informações necessárias para executar o seu teste (comandos, migrations, seeds, etc);
- Depois de finalizado, envie-nos o pull request;

## Bônus

- Implementar autenticação de usuário na aplicação. (OK)
- Permitir que o usuário mude o número de itens por página.
- Permitir deleção em massa de itens nos CRUDs.
- Implementar aplicação de desconto em alguns pedidos de compra.
- Implementar a camada de Front-End utilizando a biblioteca javascript Bootstrap e ser responsiva. (OK)
- API Rest JSON para todos os CRUDS listados acima. (OK)

## O que iremos analisar

- Organização do código;
- Conhecimento de padrões (PSRs, design patterns, SOLID);
- Separação de módulos e componentes;
- Legibilidade;
- Tratamento de erros;

### Boa sorte!
