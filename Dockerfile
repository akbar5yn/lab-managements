# Use a separate stage to install Composer to keep the final image clean and small.
FROM composer:2 AS composer_stage

# Copy your application source code into the composer stage.
WORKDIR /app
COPY composer.json composer.lock ./

# Install Composer dependencies.
RUN composer install --no-dev --optimize-autoloader

# ---

# Use the PHP FPM base image for the main application container.
FROM php:8.4-fpm-alpine

# Install system dependencies needed for your application.
# `gd-dev` is required for the `gd` PHP extension.
RUN apk add --no-cache \
    git \
    curl \
    mariadb-dev \
    pcre-dev \
    libzip-dev \
    gd-dev

# Install PHP extensions required by your application.
# `gd` is now included to satisfy the `simple-qrcode` dependency.
RUN docker-php-ext-install \
    pdo_mysql \
    zip \
    gd

# Set the working directory inside the container.
WORKDIR /var/www/html

# Copy the application code from your local machine to the container.
COPY . .

# Copy the installed Composer dependencies from the composer_stage.
COPY --from=composer_stage /app/vendor /var/www/html/vendor

# Expose the PHP-FPM port.
EXPOSE 3000

# Start the PHP-FPM process when the container runs.
CMD ["php-fpm"]
