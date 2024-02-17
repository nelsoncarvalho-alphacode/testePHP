# Crie o Arquivo .env

```bash
cp .env.example .env
```

## Atualize as variáveis de ambiente do arquivo .env

```bash
APP_NAME="NomeDoApp"
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=nome_que_desejar_db
DB_USERNAME=root
DB_PASSWORD=root
```

## Suba os containers do projeto

```bash
docker-compose up -d
```

## Acesse o container app com o bash

```bash
docker-compose exec app bash
```

## Instale as dependências do projeto

```bash
composer install
```

## Gere a key do projeto Laravel

```bash
php artisan key:generate
```

## Faça a migrate para instalar a migrations do banco de dados

```bash
php artisan migrate
```

## Para acessar o projeto fique dentro da bash do docker.

## Acesse o projeto http://localhost:8989
