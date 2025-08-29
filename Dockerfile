# Gunakan base image PHP dengan PHP-FPM
FROM php:8.4-fpm

# Set direktori kerja di dalam container
WORKDIR /var/www/html

# Install dependensi sistem yang dibutuhkan untuk PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Hapus cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP yang umum dibutuhkan Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Dapatkan Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin file composer.json dan composer.lock
COPY composer.json composer.lock ./

# Jalankan composer install di dalam container
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Salin seluruh kode aplikasi ke dalam container
COPY . .

# Atur izin (permissions)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Jalankan service PHP-FPM
CMD ["php-fpm"]
