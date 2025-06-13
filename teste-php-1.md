# App Web em Laravel para gestão de pedidos
## Stack
- PHP 8.3
- Laravel Framework
- HTML/CSS
- Bootstrap
- MySql
- Docker
- Javascript

## Features Implementadas
- CRUD de clientes.
- CRUD de produtos.
- CRUD de pedidos com status "Em Aberto", "Pago" ou "Cancelado".
- Barra de navegação entre os CRUDs.
- Links para os outros CRUDs nas listagens

## Instruções
- Clone este repositório: 
    ```git clone https://github.com/ghosthi/WebAppPedidos.git```
- Criar arquivo .env de acordo com o template .env.example
- (Opcionalmente) Editar os arquivos .env docker-compose.yml para definir credenciais de acesso ao banco de dados MySql
- Criar ambiente com docker: 
    ```docker-compose up -d --build```
- Executar migrations e data-mocking na imagem laravel-app através do docker: 
    ```docker exec -it laravel-app php artisan migrate:fresh --seed```