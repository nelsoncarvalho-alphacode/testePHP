# 🐳 Orders App - Docker Setup

Este documento explica como executar o projeto Orders App usando Docker.

## 📋 Pré-requisitos

- Docker Desktop instalado e rodando
- Docker Compose

## 🚀 Como executar

1. **Inicie os containers:**
   ```bash
   docker-compose up -d
   ```

2. **Acesse a aplicação:**
   - **Sistema:** http://localhost:8080
   - **phpMyAdmin:** http://localhost:8081

## � Credenciais de Acesso

**Administrador:**
- Email: `admin@admin.com`
- Senha: `admin123`

**phpMyAdmin:**
- Usuário: `root`
- Senha: `rootpassword`

### 1. Clone o repositório (se ainda não fez)
```bash
git clone <seu-repositorio>
cd orders-app
```

### 2. Execute o projeto com Docker Compose
```bash
docker-compose up -d
```

### 3. Acesse a aplicação
- **Aplicação**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081

## 🔧 Configurações

### Portas utilizadas:
- **8080**: Aplicação PHP/Apache
- **3306**: MySQL (acesso externo)
- **8081**: phpMyAdmin

### Credenciais do banco:
- **Host**: db (interno) / localhost (externo)
- **Database**: ordersapp
- **Usuário Root**: root
- **Senha Root**: rootpassword
- **Usuário App**: orders_user
- **Senha App**: orders_pass

### Login da aplicação:
- **Email**: admin@admin.com
- **Senha**: password

## 📁 Estrutura Docker

```
orders-app/
├── Dockerfile              # Imagem PHP/Apache
├── docker-compose.yml      # Orquestração dos serviços
├── .dockerignore           # Arquivos ignorados pelo Docker
├── database/
│   └── init.sql            # Script de inicialização do BD
└── bootstrap-docker.php    # Configurações para Docker
```

## 🛠️ Comandos úteis

### Parar os containers:
```bash
docker-compose down
```

### Ver logs da aplicação:
```bash
docker-compose logs app
```

### Ver logs do banco:
```bash
docker-compose logs db
```

### Reconstruir os containers:
```bash
docker-compose up --build
```

### Acessar container da aplicação:
```bash
docker exec -it orders-app bash
```

### Acessar MySQL via terminal:
```bash
docker exec -it orders-mysql mysql -u root -p
```

## 🔄 Backup e Restore

### Backup do banco:
```bash
docker exec orders-mysql mysqldump -u root -prootpassword ordersapp > backup.sql
```

### Restore do banco:
```bash
docker exec -i orders-mysql mysql -u root -prootpassword ordersapp < backup.sql
```

## 🐛 Troubleshooting

### Se a aplicação não conectar no banco:
1. Verifique se os containers estão rodando: `docker-compose ps`
2. Verifique os logs: `docker-compose logs`
3. Reinicie os containers: `docker-compose restart`

### Se as portas estiverem ocupadas:
Altere as portas no `docker-compose.yml`:
```yaml
ports:
  - "8090:80"  # Muda de 8080 para 8090
```

## 🔧 Desenvolvimento

Para desenvolvimento, os arquivos são montados como volume, então:
- Mudanças no código são refletidas imediatamente
- Não precisa reconstruir o container para mudanças em PHP
- Para mudanças no Dockerfile, execute: `docker-compose up --build`