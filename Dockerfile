
FROM php:8.4-cli

RUN apt-get update \
    && apt-get install -y \
       git unzip libpq-dev libonig-dev \
    && docker-php-ext-install \
       pdo_mysql pdo_pgsql mbstring \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

CMD php -S 0.0.0.0:${PORT:-10000} -t public public/index.php
