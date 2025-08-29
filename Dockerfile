# Use a separate stage to install Composer to keep the final image clean and small.
FROM composer:2 AS composer_stage

# Copy your application source code into the composer stage.
WORKDIR /app
COPY composer.json composer.lock ./

# Install Composer dependencies.
# The `--no-dev` flag skips development packages.
# The `--optimize-autoloader` flag improves performance.
RUN composer install --no-dev --optimize-autoloader

# ---

# Use the PHP FPM base image for the main application container.
FROM php:8.4-fpm-alpine

# Install system dependencies needed for your application.
# The backslashes allow you to split a single command across multiple lines.
RUN apk add --no-cache \
    git \
    curl \
    mariadb-dev \
    # The 'pcre-dev' package is often required for Laravel/PHP.
    pcre-dev \
    # The 'libzip-dev' package is required for the 'zip' extension.
    libzip-dev

# Install PHP extensions required by your application.
# The 'pdo_mysql' extension is needed for MySQL/MariaDB.
# The 'zip' extension is often required by many Composer packages.
# You don't need 'pdo_pgsql' if you're not using PostgreSQL.
RUN docker-php-ext-install \
    pdo_mysql \
    zip

# Set the working directory inside the container.
WORKDIR /var/www/html

# Copy the application code from your local machine to the container.
COPY . .

# Copy the installed Composer dependencies from the composer_stage.
COPY --from=composer_stage /app/vendor /var/www/html/vendor

# Expose the PHP-FPM port.
# Nginx or another web server will connect to this port.
# The standard port for PHP-FPM is 9000, not 3000.
EXPOSE 3000

# Start the PHP-FPM process when the container runs.
CMD ["php-fpm"]
