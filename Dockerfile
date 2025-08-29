# Stage 1: Build dependencies
FROM composer:2 AS composer_stage

WORKDIR /app
COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# ---

# Stage 2: Final image (web server)
FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    git \
    curl \
    mariadb-dev \
    pcre-dev \
    libzip-dev \
    gd-dev

# Instal ekstensi PHP.
RUN docker-php-ext-install \
    pdo_mysql \
    zip \
    gd

WORKDIR /var/www/html

# Salin seluruh kode aplikasi dari host.
COPY . .

# Salin vendor yang sudah diinstal dari stage pertama.
COPY --from=composer_stage /app/vendor /var/www/html/vendor

RUN composer dump-autoload --optimize && php artisan package:discover --ansi

EXPOSE 9000

CMD ["php-fpm"]
