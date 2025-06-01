# Use prebuilt base image (with GRPC & dependencies already installed)
FROM sikancil/backend-base AS app

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
