# Dockerfile para o projeto orders-app
FROM php:8.2-apache

# Instala extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilita mod_rewrite do Apache
RUN a2enmod rewrite

# Define variável de ambiente para indicar que está no Docker
ENV DOCKER_ENV=true

# Copia arquivos do projeto para o container
COPY . /var/www/html/

# Define permissões corretas
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/

# Configura Apache para usar .htaccess
RUN echo '<Directory /var/www/html/>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/override.conf \
&& a2enconf override

# Expõe porta 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]