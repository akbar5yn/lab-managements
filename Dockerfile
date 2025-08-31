FROM serversideup/php:8.2-fpm-nginx

WORKDIR /var/www/html

USER root

# Install the GD extension and its dependencies
# The backslashes allow the command to span multiple lines for readability
RUN apt-get update && apt-get install -y libwebp-dev libjpeg-dev libpng-dev \
    && docker-php-ext-configure gd --with-webp --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

USER www-data

COPY --chown=www-data:www-data . .

RUN composer install --no-dev --optimize-autoloader
