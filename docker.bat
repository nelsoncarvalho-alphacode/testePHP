@echo off
REM Script de conveniência para Windows - gerenciar o projeto Docker

if "%1"=="start" (
    echo 🚀 Iniciando Orders App...
    docker-compose up -d
    echo ✅ Aplicação disponível em: http://localhost:8080
    echo 📊 phpMyAdmin disponível em: http://localhost:8081
) else if "%1"=="stop" (
    echo 🛑 Parando Orders App...
    docker-compose down
) else if "%1"=="restart" (
    echo 🔄 Reiniciando Orders App...
    docker-compose restart
) else if "%1"=="logs" (
    echo 📋 Exibindo logs...
    docker-compose logs -f
) else if "%1"=="build" (
    echo 🔨 Reconstruindo containers...
    docker-compose up --build -d
) else if "%1"=="shell" (
    echo 🐚 Acessando shell do container...
    docker exec -it orders-app bash
) else if "%1"=="mysql" (
    echo 🗄️ Acessando MySQL...
    docker exec -it orders-mysql mysql -u root -prootpassword ordersapp
) else if "%1"=="backup" (
    echo 💾 Criando backup do banco...
    for /f "tokens=2 delims==" %%a in ('wmic OS Get localdatetime /value') do set "dt=%%a"
    set "YY=%dt:~2,2%" & set "YYYY=%dt:~0,4%" & set "MM=%dt:~4,2%" & set "DD=%dt:~6,2%"
    set "HH=%dt:~8,2%" & set "Min=%dt:~10,2%" & set "Sec=%dt:~12,2%"
    set "datestamp=%YYYY%%MM%%DD%_%HH%%Min%%Sec%"
    docker exec orders-mysql mysqldump -u root -prootpassword ordersapp > backup_%datestamp%.sql
    echo ✅ Backup criado!
) else (
    echo 🐳 Orders App - Docker Manager
    echo.
    echo Comandos disponíveis:
    echo   start    - Inicia a aplicação
    echo   stop     - Para a aplicação
    echo   restart  - Reinicia a aplicação
    echo   logs     - Exibe logs em tempo real
    echo   build    - Reconstrói os containers
    echo   shell    - Acessa shell do container da app
    echo   mysql    - Acessa MySQL via terminal
    echo   backup   - Cria backup do banco de dados
    echo.
    echo Exemplo: docker.bat start
)