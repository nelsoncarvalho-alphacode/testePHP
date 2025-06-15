<h1>Como rodar a aplicação:</h1>

1. Para instalar as dependencias do PHP:<br>
		`cd src && composer install && cd ..`<br><br>

2. Para subir o contâiner Docker:<br>
		`docker-compose up -d --build`<br><br>
3. Para gerar a chave da aplicação Laravel e rodar as migrations:<br>
		`docker-compose exec app php artisan key:generate && docker-compose exec app php artisan migrate`<br><br>
4. Para rodar os seeders e preencher o banco de dados:<br>
		`docker-compose exec app php artisan db:seed`<br><br>

5. Por fim, para instalar as dependencias Node e fazer o build do JS:<br>
		`cd src && npm install && npm run build`<br><br>
  
Após isso, é só acessar o `http://localhost:8080`, e fazer login com as credenciais:<br>
	E-mail: alphacode@email.com<br>
	Senha: 123456
