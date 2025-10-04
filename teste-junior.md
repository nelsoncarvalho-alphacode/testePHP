# Pedify – Sistema de Gestão de Pedidos

---

## Visão Geral  

O Pedify é um sistema web completo para gestão de pedidos, criado por mim, Guilherme Rocha.  
Foi desenvolvido em PHP 8, utilizando banco de dados MySQL, Docker e interface responsiva com Bootstrap 5.

O projeto tem como objetivo entregar uma solução robusta e escalável para controle de operações comerciais e gestão de pedidos.  

---

## Funcionalidades  

- Autenticação de usuários (login e registro, com senhas criptografadas)  
- Gestão de clientes com validação de CPF  
- Gestão de produtos, estoque e preços  
- Criação e gerenciamento de pedidos com múltiplos itens  
- Aplicação de descontos em pedidos  
- Dashboard com estatísticas  
- Busca, filtros e paginação configurável  
- Exclusão individual ou em massa  
- Interface moderna, responsiva e intuitiva  

---

## Tecnologias  

- PHP 8  
- MySQL
- Bootstrap
- Docker

---

## Estrutura do Projeto  

```
pedify/
├── src/
│   ├── config/              # Configuração e Banco de Dados
│   ├── models/              # Models
│   ├── controllers/         # Controllers (exemplos)
│   ├── views/               # Views
│   ├── index.php            # Dashboard
│   ├── login.php            # Login
│   ├── register.php         # Registro
│   └── logout.php           # Logout
├── docker-compose.yml
├── Dockerfile
├── dbexample.sql             # Schema + dados iniciais
```  

---

## Instalação  

### 1. Pré-requisitos  
- [Docker](https://www.docker.com/) 20.10+  

### 2. Configuração e execução  

```bash
# Build e inicialização dos containers
docker-compose up -d --build
```

### 3. Banco de Dados  
- Acesse o phpMyAdmin em: http://localhost:8081  
- Criar database `testephp` no banco, seguindo o arquivo `dbexample.sql` (ou importar o arquivo `testephp.sql`)
- Seed database com os dados iniciais. (também seguindo o arquivo `dbexample.sql`)

### 4. Acessos  
- Pedify: http://localhost:8080  
- PhpMyAdmin: http://localhost:8081  

---

## Credenciais de acesso

**Usuário padrão no sistema**  
- Email: admin@teste.com  
- Senha: admin123  

**Banco de Dados**  
- Host: db  
- Database: testephp  
- Usuário: root  
- Senha: phpteste  

---

## Estrutura de Dados  

**Tabelas principais:**  
- usuarios  
- clientes  
- produtos  
- pedidos  
- pedido_itens  

---

## Interface  

- Layout responsivo com Bootstrap 5  
- Navegação estruturada por módulos  
- Feedback visual para ações do usuário  
- Breadcrumbs e validações de formulário  

---

## Segurança  

- Senhas criptografadas (password_hash)  
- PDO com anti-SQL Injection  
- Proteção contra XSS (htmlspecialchars)
- Sessões seguras e validações no backend  

---

## Comandos Docker  

```bash
# Iniciar containers
docker-compose up -d

# Parar containers
docker-compose down

```

Após instalar todas as dependências necessários e executar todos os comandos acima, o sistema estará pronto para ser utilizado.

---