# Multi-stage build for Google Earth VR Custom Tour Generator
# Stage 1: Composer dependencies
FROM composer:2.6 as composer

WORKDIR /app
COPY composer.json composer.lock* ./

# Install dependencies
RUN composer install --no-scripts --no-autoloader --no-dev

# Stage 2: Node.js for frontend assets
FROM node:20-alpine as node

WORKDIR /app
COPY package.json ./
RUN npm install

COPY resources/ ./resources/
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

# Stage 3: Final image
FROM php:8.3-apache

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip opcache \
    && pecl install apcu \
    && docker-php-ext-enable apcu

# Configure PHP
COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
RUN a2enmod rewrite headers

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html
COPY --from=composer /app/vendor/ /var/www/html/vendor/
COPY --from=node /app/public/build/ /var/www/html/public/build/

# Generate optimized autoloader
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer dump-autoload --optimize --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set environment variables
ENV APP_ENV=production
ENV APP_DEBUG=false

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]