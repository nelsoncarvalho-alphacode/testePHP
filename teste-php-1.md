========= Funcionalidades ================

A conexão de banco de dados utilizada é mysql
Basta preencher as credenciais da sua conexão no arquivo .env


 Comando para rodar as migration:
 Comando: php artisan migrate

 Obs: vai gerar as tabelas corretamente


 Comando para preecher o banco (Seeders)
 comando: php artisan db:seed --class=ProdutoSeeder

Comando para subir o projeto:
 - php artisan server

 Obs* caso tenha problema no layout
Necessita do node nas versões acima da 18
Roda o comando: npm run dev (Não deve afetar funcionalidades, apenas questão estética)

Obs2* caso aja algum problema nas rotas:
 comando: php artian cache:clear
 comando: php artisan optimize