# Use the official PHP image with FPM
FROM php:8.2-fpm

# Set the working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear the apt cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create cache and storage directories with proper permissions
RUN mkdir -p /var/www/storage/framework/{cache,sessions,views} /var/www/storage/logs /var/www/bootstrap/cache && \
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy the existing application directory contents
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node.js dependencies and build assets
RUN npm install && npm run build

# Set permissions for Laravel
RUN composer dump-autoload --optimize && \
    composer run-script post-autoload-dump && \
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
