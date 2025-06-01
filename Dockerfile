FROM php:8.3-fpm AS base

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    nano \
    libsodium23 \
    nginx \
    cron \
    supervisor \
    && docker-php-ext-configure --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql opcache zip intl

# Install Node.js & npm (latest version)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set Workdir
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader

# Copy Nginx config
COPY ./nginx.conf /etc/nginx/nginx.conf

# Link storage
RUN php artisan storage:link

# Expose port 80
EXPOSE 80

# Start all services using Supervisor
CMD ["php-fpm"]
