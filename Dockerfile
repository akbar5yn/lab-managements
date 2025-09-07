# ===============================================
# STAGE 1: Build Image (untuk instalasi dependensi)
# ===============================================
FROM php:8.3-fpm AS builder

# Instal dependensi sistem dan ekstensi PHP
RUN apt-get update && apt-get install -y \
    git \
    npm \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libicu-dev \
    libpq-dev \
    libmysqlclient-dev \
    build-essential \
    zlib1g-dev \
    && docker-php-ext-install pdo_mysql opcache gd intl zip exif

# Atur working directory dan salin Composer
WORKDIR /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin kode aplikasi
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm ci
RUN npm run build

# ===============================================
# STAGE 2: Production Image (lebih ringan)
# ===============================================
FROM php:8.3-fpm

# Instal dependensi runtime dan Nginx
RUN apt-get update && apt-get install -y nginx supervisor

# Atur working directory
WORKDIR /var/www/html

# Salin aplikasi yang sudah di-build dari Stage 1
COPY --from=builder /var/www/html /var/www/html

# Atur izin file
RUN chown -R www-data:www-data /var/www/html

# Salin konfigurasi Nginx dan Supervisor
COPY .docker/nginx/nginx.conf /etc/nginx/sites-available/default
COPY .docker/supervisord/supervisord.conf /etc/supervisord.conf

# Ekspos port
EXPOSE 80

# Jalankan Nginx dan PHP-FPM menggunakan Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
