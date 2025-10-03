#!/bin/bash

# Script de conveniência para gerenciar o projeto Docker

case "$1" in
    "start")
        echo "🚀 Iniciando Orders App..."
        docker-compose up -d
        echo "✅ Aplicação disponível em: http://localhost:8080"
        echo "📊 phpMyAdmin disponível em: http://localhost:8081"
        ;;
    "stop")
        echo "🛑 Parando Orders App..."
        docker-compose down
        ;;
    "restart")
        echo "🔄 Reiniciando Orders App..."
        docker-compose restart
        ;;
    "logs")
        echo "📋 Exibindo logs..."
        docker-compose logs -f
        ;;
    "build")
        echo "🔨 Reconstruindo containers..."
        docker-compose up --build -d
        ;;
    "shell")
        echo "🐚 Acessando shell do container..."
        docker exec -it orders-app bash
        ;;
    "mysql")
        echo "🗄️ Acessando MySQL..."
        docker exec -it orders-mysql mysql -u root -prootpassword ordersapp
        ;;
    "backup")
        echo "💾 Criando backup do banco..."
        docker exec orders-mysql mysqldump -u root -prootpassword ordersapp > "backup_$(date +%Y%m%d_%H%M%S).sql"
        echo "✅ Backup criado!"
        ;;
    *)
        echo "🐳 Orders App - Docker Manager"
        echo ""
        echo "Comandos disponíveis:"
        echo "  start    - Inicia a aplicação"
        echo "  stop     - Para a aplicação"
        echo "  restart  - Reinicia a aplicação"
        echo "  logs     - Exibe logs em tempo real"
        echo "  build    - Reconstrói os containers"
        echo "  shell    - Acessa shell do container da app"
        echo "  mysql    - Acessa MySQL via terminal"
        echo "  backup   - Cria backup do banco de dados"
        echo ""
        echo "Exemplo: ./docker.sh start"
        ;;
esac