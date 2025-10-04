FROM php:8.2-apache

# Instala extensões necessárias (MySQL e PDO )
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia o código da pasta src para dentro do container
COPY ./src /var/www/html/

# Habilita o mod_rewrite do Apache (apenas se precisar para rotas)
RUN a2enmod rewrite
