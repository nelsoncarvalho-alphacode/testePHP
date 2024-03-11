# Projeto AlphaCode

Este é um projeto Laravel incrível desenvolvido por Henrique Matos(https://github.com/RyckMatos).

## Requisitos

- PHP >= 7.3
- Composer
- MySQL ou outro sistema de gerenciamento de banco de dados suportado pelo Laravel

## Configuração do Ambiente

1. Clone o repositório para o seu ambiente local:

    ```bash
    git clone https://github.com/RyckMatos/testePHP.git
    ```

2. Instale as dependências do Composer:

    ```bash
    composer install
    ```

3. Copie o arquivo de configuração do ambiente:

    ```bash
    cp .env.example .env
    ```

4. Gere a chave de aplicativo do Laravel:

    ```bash
    php artisan key:generate
    ```

5. Configure o arquivo `.env` com suas configurações de banco de dados.

6. Execute as migrações do banco de dados para criar as tabelas necessárias:

    ```bash
    php artisan migrate
    ```

7. (Opcional) Se desejar, você pode popular o banco de dados com dados de amostra usando as seeds:

    ```bash
    php artisan db:seed
    ```

## Executando o Servidor de Desenvolvimento

Para iniciar o servidor de desenvolvimento do Laravel, você pode usar o comando:

```bash
php artisan serve
