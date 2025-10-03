# Multi-stage build for Laravel application
FROM node:20-alpine AS node-builder

WORKDIR /app

# Copy package files
COPY package*.json ./

# Install Node.js dependencies (including devDependencies for build)
RUN npm ci

# Copy source code
COPY . .

# Build assets
RUN npm run build

# PHP base image with extensions
FROM php:8.2-fpm-alpine AS php-base

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    icu-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create application directory
WORKDIR /var/www/html

# Copy composer files
COPY composer*.json ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application code
COPY . .

# Copy built assets from node-builder
COPY --from=node-builder /app/public/build ./public/build

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Create startup script for Laravel setup
RUN echo '#!/bin/sh' > /usr/local/bin/laravel-setup.sh && \
    echo 'set -e' >> /usr/local/bin/laravel-setup.sh && \
    echo '' >> /usr/local/bin/laravel-setup.sh && \
    echo '# Generate application key if not exists' >> /usr/local/bin/laravel-setup.sh && \
    echo 'if [ ! -f .env ]; then' >> /usr/local/bin/laravel-setup.sh && \
    echo '    cp .env.example .env' >> /usr/local/bin/laravel-setup.sh && \
    echo 'fi' >> /usr/local/bin/laravel-setup.sh && \
    echo '' >> /usr/local/bin/laravel-setup.sh && \
    echo 'php artisan key:generate --no-interaction || true' >> /usr/local/bin/laravel-setup.sh && \
    echo '' >> /usr/local/bin/laravel-setup.sh && \
    echo '# Run migrations' >> /usr/local/bin/laravel-setup.sh && \
    echo 'php artisan migrate --force || true' >> /usr/local/bin/laravel-setup.sh && \
    echo '' >> /usr/local/bin/laravel-setup.sh && \
    echo '# Clear and cache configurations' >> /usr/local/bin/laravel-setup.sh && \
    echo 'php artisan config:cache' >> /usr/local/bin/laravel-setup.sh && \
    echo 'php artisan route:cache' >> /usr/local/bin/laravel-setup.sh && \
    echo 'php artisan view:cache' >> /usr/local/bin/laravel-setup.sh && \
    echo '' >> /usr/local/bin/laravel-setup.sh && \
    echo '# Start PHP-FPM' >> /usr/local/bin/laravel-setup.sh && \
    echo 'exec php-fpm' >> /usr/local/bin/laravel-setup.sh

RUN chmod +x /usr/local/bin/laravel-setup.sh

EXPOSE 9000

CMD ["/usr/local/bin/laravel-setup.sh"]
