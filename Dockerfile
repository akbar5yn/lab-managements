# Use a separate stage to install Composer dependencies. This keeps the final image size down.
FROM composer:2 AS composer_stage

# Set the working directory for Composer.
WORKDIR /app

# Copy the Composer files first to leverage Docker's caching.
COPY composer.json composer.lock ./

# Install Composer dependencies, ignoring platform requirements like PHP extensions.
# The `--ignore-platform-reqs` flag is crucial to prevent the build from failing due to missing extensions.
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# ---

# This is the final image, built from the PHP FPM base image.
FROM php:8.4-fpm-alpine

# Install system dependencies.
# The `gd-dev` library is the system dependency for the `gd` PHP extension.
RUN apk add --no-cache \
    git \
    curl \
    mariadb-dev \
    pcre-dev \
    libzip-dev \
    gd-dev

# Install PHP extensions required by your application.
# `pdo_mysql` is for MySQL, `zip` is for many Composer packages, and `gd` is for QR codes.
RUN docker-php-ext-install \
    pdo_mysql \
    zip \
    gd

# Set the working directory inside the container for your application code.
WORKDIR /var/www/html

# Copy the entire application codebase.
COPY . .

# Copy the installed Composer dependencies from the first stage.
COPY --from=composer_stage /app/vendor /var/www/html/vendor

# Expose the PHP-FPM port.
EXPOSE 9000

# Start the PHP-FPM process when the container runs.
CMD ["php-fpm"]
