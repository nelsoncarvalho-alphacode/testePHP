FROM php:8.1-fpm-alpine

RUN apk add --no-cache \
    libzip-dev \
    zip \
    libpq \
    libxml2-dev \
    libpng-dev \
    freetype-dev \
    jpeg-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libharu-dev \
    musl-dev \
    oniguruma-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo_mysql mbstring gd

WORKDIR /var/www/html
COPY . .

RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000