# Gunakan base image PHP yang kompatibel
FROM php:8.4-fpm-alpine

# Install ekstensi dan dependensi yang dibutuhkan oleh Laravel
RUN apk add --no-cache \
    bash \
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
    postgresql-dev \
    gd \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath zip gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Salin file composer.json dan composer.lock
COPY composer.json composer.lock ./

# Jalankan composer install
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Salin seluruh kode aplikasi
COPY . .

# Atur permission
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Atur PHP-FPM
CMD ["php-fpm"]
