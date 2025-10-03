# 🚀 Teste Técnico - Desenvolvedor PHP

Aplicação desenvolvida para o **teste técnico de Desenvolvedor PHP**, que consiste em implementar um sistema de gerenciamento de **vagas** e **candidatos**, permitindo inscrições, CRUDs completos, API REST JSON e documentação automática.

---

## 📦 Tecnologias Utilizadas
- [PHP 8.2](https://www.php.net/) com [Laravel](https://laravel.com/)  
- [MySQL 8.1](https://www.mysql.com/)  
- [Docker + Docker Compose](https://www.docker.com/)  
- [phpMyAdmin](https://www.phpmyadmin.net/)  
- [Scribe](https://scribe.knuckles.wtf/) para documentação de API  
- [JavaScript](https://developer.mozilla.org/pt-BR/docs/Web/JavaScript) para interações no frontend  
- [Bootstrap 5](https://getbootstrap.com/) para layout responsivo  
- [Bootstrap Icons](https://icons.getbootstrap.com/) para ícones  
- [CSS customizado](https://developer.mozilla.org/pt-BR/docs/Web/CSS) para ajustes de estilo  
- [Blade Components](https://laravel.com/docs/blade#components) para componentes reutilizáveis  


---

## ⚙️ Como rodar o projeto

### 1. Clonar o repositório
```bash
git clone <url-do-repositorio>
cd testePHP


2. Subir containers
docker-compose up -d --build

Containers criados:
php_app → Laravel rodando em http://localhost:8080
mysql_db → Banco MySQL em localhost:3308
phpmyadmin → Acesso via http://localhost:8081 (usuário: laravel, senha: laravel)


3. Instalar dependências
docker exec -it php_app composer install

4. Configurar ambiente
docker exec -it php_app cp .env.example .env

Gerar chave da aplicação:
docker exec -it php_app php artisan key:generate

5. Rodar migrations e seeds

docker exec -it php_app php artisan migrate --seed


📂 Estrutura de Módulos

Vagas

Criar, listar, atualizar, deletar

Status: ativa, pausada

Candidatos

Criar, listar, atualizar, deletar

Um candidato pode se inscrever em várias vagas

Inscrições

Relacionamento entre candidatos e vagas

Permite adicionar/remover vagas em edição de candidato


📡 API REST

A API está disponível em:

http://localhost:8080/api

Principais endpoints:
GET /api/vagas → listar vagas
POST /api/vagas → criar vaga
GET /api/candidatos → listar candidatos
POST /api/candidatos → criar candidato
GET /api/inscricoes → listar inscrições
etc.

📖 Documentação da API
Gerada automaticamente com Scribe.
http://localhost:8080/docs

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu_email@gmail.com
MAIL_PASSWORD=sua_chave_de_aplicativo
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu_email@gmail.com
MAIL_FROM_NAME="Recrutamento"
## 📧 Configuração de E-mail

Para que o envio de e-mails (ex.: recuperação de senha) funcione, é necessário configurar as credenciais SMTP no arquivo `.env`.

Exemplo de configuração com Gmail:



🛠️ Comandos úteis
Regerar documentação:
docker exec -it php_app php artisan scribe:generate

Publicar assets do Scribe (rodar 1x):
docker exec -it php_app php artisan vendor:publish --tag=scribe-assets


## ✅ Funcionalidades Implementadas

- **CRUD de Vagas**
  - Criar, editar, excluir e listar vagas
  - Tipos: CLT, PJ e Freelancer
  - Status: Ativa ou Pausada (pausadas não aceitam inscrições)

- **CRUD de Candidatos**
  - Criar, editar, excluir e listar candidatos
  - Inscrição em múltiplas vagas
  - Editar candidato permite adicionar ou remover vagas ativas
  - Gerenciamento completo dos dados (nome, email, telefone, currículo)

- **CRUD de Inscrições**
  - Relacionamento N:N entre vagas e candidatos
  - Gerenciamento centralizado pelo candidato
  - Possibilidade de adicionar/remover inscrições ao editar o candidato

- **Validações**
  - Campos obrigatórios e tipos de dados (email, telefone, etc)
  - Regras de consistência (não se inscrever em vaga pausada)

- **Paginação, ordenação e filtros**
  - Todos os CRUDs com paginação (20 itens por página por padrão)
  - Parâmetro `per_page` para paginação customizável
  - Ordenação e filtros por qualquer campo

- **API REST JSON**
  - Endpoints completos para Vagas, Candidatos e Inscrições
  - Suporte a deleção em massa
  - Documentação da API integrada com **Scribe** (HTML + Postman + OpenAPI)

- **Autenticação**
  - Sistema de login e registro de usuários
  - Rotas protegidas por middleware `auth`
  - Fluxo de autenticação integrado com Laravel

- **Interface**
  - Layout responsivo com **Bootstrap 5**
  - Ícones com **Bootstrap Icons**
  - Estilização extra com **CSS customizado**
  - Componentização com **Blade Components** (`x-ui.input`, `x-ui.button`, etc)

