FROM node:22 AS node_build

WORKDIR /var/www/html

# Copy dan instal dependensi Node.js
COPY package.json package-lock.json ./
RUN npm install

# Copy kode aplikasi dan jalankan build
COPY . .
RUN npm run build

FROM php:8.2-fpm

WORKDIR /var/www/html

# Update dan instal paket sistem
RUN apt-get update && apt-get install -y \
    libwebp-dev \
    libjpeg-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    unzip \
    git \
    libcurl4-openssl-dev \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Instal dan konfigurasikan ekstensi PHP
RUN docker-php-ext-configure gd --with-webp --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql mbstring zip curl

# Copy Composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ubah UID user
RUN usermod -u 1000 www-data

# Copy kode aplikasi
COPY . .

# Pastikan direktori storage memiliki izin yang benar
RUN chown -R www-data:www-data /var/www/html \
    && chown -R www-data:www-data storage bootstrap/cache

# Jalankan instalasi Composer
RUN composer install --no-dev --optimize-autoloader
