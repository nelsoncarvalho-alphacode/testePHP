Nome: Rafael_Ribeiro_Domingues

Teste: teste-php-2 (vagas/candidatos)

Este é um projeto Laravel construído com Laravel Sail, Tailwind CSS e MySQL. Ele utiliza o Laravel Sail para gerenciar o ambiente de desenvolvimento via Docker, simplificando a configuração de todas as dependências necessárias.

Pré-requisitos
Antes de começar, certifique-se de ter o Docker Desktop (para Windows/macOS) ou o Docker Engine (para Linux) instalado e rodando em sua máquina.

Docker: https://www.docker.com/get-started/

Instalação e Execução
Siga os passos abaixo para configurar e rodar o projeto localmente:

Clonar o repositório e navegar até ele:

git clone https://github.com/rdRafael/testePHP.git
cd nome-do-seu-projetoNome: Rafael_Ribeiro_Domingues
Teste: teste-php-2 (candidatos/vagas)
Este é um projeto Laravel construído com Laravel Sail, Tailwind CSS e MySQL. Ele utiliza o Laravel Sail para gerenciar o ambiente de desenvolvimento via Docker, simplificando a configuração de todas as dependências necessárias.

O código-fonte do projeto principal está localizado na pasta alphacode.

Pré-requisitos
Antes de começar, certifique-se de ter o Docker Desktop (para Windows/macOS) ou o Docker Engine (para Linux) instalado e rodando em sua máquina.

Docker: https://www.docker.com/get-started/

Instalação e Execução
Siga os passos abaixo para configurar e rodar o projeto localmente:

Clonar o repositório e navegar até ele:

git clone https://https://github.com/rdRafael/testePHP.git
cd alphacode

Observação: O código principal do projeto está na subpasta alphacode.
Iniciar o Laravel Sail:

Este comando iniciará todos os serviços Docker necessários (PHP, Nginx, MySQL, etc.) em segundo plano.

./vendor/bin/sail up -d

Instalar dependências PHP:

Instale as dependências do Composer dentro do contêiner do Sail.

./vendor/bin/sail composer install

Copiar o arquivo .env e gerar a chave da aplicação:

Crie o arquivo de configuração de ambiente e gere a chave única da aplicação.

cp .env.example .env
./vendor/bin/sail artisan key:generate

Se necessário, edite o arquivo .env para ajustar quaisquer variáveis de ambiente específicas do seu ambiente local.

Rodar migrações do banco de dados 

Execute as migrações para criar as tabelas no banco de dados 

./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed ## criar o admin

Instalar dependências JavaScript/CSS e compilar assets (se aplicável):

./vendor/bin/sail npm install
./vendor/bin/sail npm run dev 
Acesso à Aplicação
Após seguir todos os passos de instalação e com o Sail rodando (./vendor/bin/sail up -d), você pode acessar a aplicação no seu navegador através do seguinte endereço:

http://localhost

Credenciais de Login (Admin)
Para acessar a área administrativa ou funcionalidades de teste, utilize as seguintes credenciais:

Email: admin@gmail.com

Senha: password

Comandos Úteis do Sail
Você pode simplificar o uso dos comandos do Sail criando um alias no seu terminal (adicione alias sail='bash vendor/bin/sail' ao seu ~/.bashrc ou ~/.zshrc). Assim, em vez de ./vendor/bin/sail, você pode usar apenas sail.

Parar os serviços do Sail: sail down

Reconstruir as imagens do Docker (útil após alterações nos Dockerfiles): sail build --no-cache

Executar comandos Artisan: sail artisan [comando] (ex: sail artisan make:model User)

Acessar o terminal dentro do contêiner da aplicação: sail bash

Estrutura do Repositório e Branches
Observação: Para trabalhar com a branch Rafael_Ribeiro_Domingues, você pode usar git checkout Rafael_Ribeiro_Domingues após clonar o repositório.



Certifique-se de substituir https://github.com/usuario/nome-do-seu-projeto.git pelo URL real do seu repositório.

Iniciar o Laravel Sail:

Este comando iniciará todos os serviços Docker necessários (PHP, Nginx, MySQL, etc.) em segundo plano.

./vendor/bin/sail up -d

Instalar dependências PHP:

Instale as dependências do Composer dentro do contêiner do Sail.

./vendor/bin/sail composer install

Copiar o arquivo .env e gerar a chave da aplicação:

Crie o arquivo de configuração de ambiente e gere a chave única da aplicação.

cp .env.example .env
./vendor/bin/sail artisan key:generate

Se necessário, edite o arquivo .env para ajustar quaisquer variáveis de ambiente específicas do seu ambiente local.

Rodar migrações do banco de dados (e seeders, se houver):

Execute as migrações para criar as tabelas no banco de dados e, opcionalmente, os seeders para popular com dados iniciais/de teste.

./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed # Opcional: só se o projeto tiver seeders para popular o banco de dados

Instalar dependências JavaScript/CSS e compilar assets (se aplicável):

Se o projeto utiliza assets front-end que precisam ser compilados (ex: via Vite, Webpack, ou Laravel Mix), execute os comandos abaixo:

./vendor/bin/sail npm install
./vendor/bin/sail npm run dev # Para desenvolvimento (compila e monitora alterações)
# Ou
# ./vendor/bin/sail npm run build # Para produção (otimiza os assets)

Acesso à Aplicação
Após seguir todos os passos de instalação e com o Sail rodando (./vendor/bin/sail up -d), você pode acessar a aplicação no seu navegador através do seguinte endereço:

http://localhost

Credenciais de Login (Admin)
Para acessar a área administrativa ou funcionalidades de teste, utilize as seguintes credenciais:

Email: admin@gmail.com

Senha: password

Comandos Úteis do Sail
Você pode simplificar o uso dos comandos do Sail criando um alias no seu terminal (adicione alias sail='bash vendor/bin/sail' ao seu ~/.bashrc ou ~/.zshrc). Assim, em vez de ./vendor/bin/sail, você pode usar apenas sail.

Parar os serviços do Sail: sail down

Reconstruir as imagens do Docker (útil após alterações nos Dockerfiles): sail build --no-cache

Executar comandos Artisan: sail artisan [comando] (ex: sail artisan make:model User)

Acessar o terminal dentro do contêiner da aplicação: sail bash