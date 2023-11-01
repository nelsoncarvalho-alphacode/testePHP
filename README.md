## About project

This project is development with Laravel Sail, Docker, MySQL.

### Funcionalidades implementadas

[x] CRUD Clientes
[x] CRUD Produtos
[x] CRUD PEDIDOS
[x] SEEDER para Status dos pedidos
[x] Barra de navegação entre os CRUDs.
[x] Links para os outros CRUDs nas listagens 

### Bonus
[x] Permitir que o usuário mude o número de itens por página.
[x] Implementar aplicação de desconto em alguns pedidos de compra.
[x] Implementar a camada de Front-End utilizando a biblioteca javascript Bootstrap e ser responsiva.
[x] API Rest JSON para todos os CRUDS listados acima.

## Running project in localhost

- Create .env file to use when docker is building
  ```cp .env.example .env```

- Installing dependencies to use composer with docker
  ```docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs```

- Exec project
```./vendor/bin/sail up -d```

- Access docker
```docker exec -it name_container bash```

- Access directory and exec commands
```cd resources/assets/hyper```
    
- Yarn install depedences layout Hyper 
  ```yarn install -g```

- Render deployed templet (Hyper)
  ```npx gulp (selecione Saas)```

- Quando finalizar vai ficar a linha abaixo, basta da CTRL + C sair. 
  [Browsersync] Couldn't open browser (if you are using BrowserSync in a headless environment, you might want to set the open option to false)

- Return raiz project and exec commands Artisan
  ```cd ../../..```
  ```php artisan key:generate```
  ```php artisan migrate```
  ```php artisan db:seed```


