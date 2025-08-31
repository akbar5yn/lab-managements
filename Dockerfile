# Tahap 1: Build - Mempersiapkan aplikasi Laravel
FROM php:8.4-fpm-alpine AS builder

WORKDIR /app

# Install dependensi PHP
RUN apk add --no-cache \
    git \
    curl \
    openssl \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    oniguruma-dev \
    libxml2-dev \
    mysql-client \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath zip gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json composer.lock ./



RUN composer install --no-dev --no-interaction --optimize-autoloader

FROM php:8.4-fpm-alpine

RUN apk add --no-cache nginx

COPY --from=builder /app /var/www/html

COPY nginx.conf /etc/nginx/http.d/default.conf

RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache

WORKDIR /var/www/html

EXPOSE 3000

CMD sh -c "php-fpm && nginx -g 'daemon off;'"
