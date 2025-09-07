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
    && docker-php-ext-install pdo_mysql opcache gd intl zip exif


# Atur working directory dan salin Composer
WORKDIR /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin kode aplikasi
COPY . .

COPY .env .env

# Instal dependensi PHP dan JavaScript
RUN composer install --no-dev --optimize-autoloader
RUN npm ci
RUN npm run build

# ===============================================
# STAGE 2: Production Image (lebih ringan)
# ===============================================
FROM php:8.3-fpm

# Instal dependensi runtime, Nginx, dan ekstensi PHP
RUN apt-get update && apt-get install -y \
    nginx \
    libmariadb-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libicu-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo_mysql opcache gd intl zip exif

# Atur working directory dan salin aplikasi
WORKDIR /var/www/html
COPY --from=builder /var/www/html /var/www/html

# Atur izin file
RUN chown -R www-data:www-data /var/www/html

# Salin konfigurasi Nginx
COPY docker/nginx/nginx.conf /etc/nginx/sites-available/default
# Hapus salinan file supervisord.conf

# Ekspos port
EXPOSE 80 9000

# Ganti perintah CMD menjadi "none" untuk Dockerfile
CMD ["php-fpm"]
