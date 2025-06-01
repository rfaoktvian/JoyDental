FROM php:8.3-fpm AS base

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    libicu-dev \
    libsodium23 \
    unzip \
    nginx \
    cron \
    supervisor \
    && docker-php-ext-install pdo pdo_mysql opcache zip intl

# Install Node.js & npm (v20 + latest npm)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Copy Nginx and Supervisor configs
COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./supervisord.conf /etc/supervisord.conf

RUN npm install

RUN npm run build

# Laravel setup: storage linking
RUN php artisan storage:link \
    && chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage

# Expose HTTP port
EXPOSE 80

# Start all services with Supervisor
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
