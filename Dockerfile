FROM php:8.4-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    postgresql-dev \
    ...

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    ...

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Install Composer dependencies
COPY --from=composer/composer:2-bin /composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Expose port 3000
EXPOSE 3000

CMD ["php-fpm"]
