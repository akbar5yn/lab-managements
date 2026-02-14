# ===============================================
# STAGE 1: Build Image (untuk instalasi dependensi)
# ===============================================
FROM php:8.3-fpm AS builder

# Instal dependensi sistem dan ekstensi PHP
RUN apt-get update && apt-get install -y \
    git \
    nodejs \
    npm \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libicu-dev \
    libmariadb-dev \
    build-essential \
    zlib1g-dev \
    && docker-php-ext-install pdo_mysql opcache gd intl zip exif \
    && pecl install redis \
    && docker-php-ext-enable redis


# Atur working directory dan salin Composer
WORKDIR /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin kode aplikasi
COPY . .

# Instal dependensi PHP dan JavaScript
RUN composer install --no-dev --optimize-autoloader
RUN npm ci
RUN npm run build

# ===============================================
# STAGE 2: Production Image (lebih ringan)
# ===============================================
FROM php:8.3-fpm

ENV TZ=Asia/Jakarta
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone

# Instal dependensi runtime dan ekstensi PHP (HAPUS NGINX)
RUN apt-get update && apt-get install -y \
    libmariadb-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libicu-dev \
    zlib1g-dev \
    openssl \
    ca-certificates \
    && docker-php-ext-install pdo_mysql opcache gd intl zip exif \
    && pecl install redis \
    && docker-php-ext-enable redis

# Atur working directory dan salin aplikasi
WORKDIR /var/www/html
COPY --from=builder /var/www/html /var/www/html

# Atur izin file
RUN chown -R www-data:www-data /var/www/html

# Konfigurasi Nginx dan port dihapus

# Ekspos port hanya untuk PHP-FPM
EXPOSE 9000

# Perintah CMD
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
