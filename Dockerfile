FROM php:8.2-fpm

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

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create application user
RUN groupadd -g 1000 www && \
    useradd -u 1000 -ms /bin/bash -g www www

# Set working directory
WORKDIR /var/www

# Copy files with proper permissions
COPY --chown=www:www . .

# Install dependencies
RUN mkdir -p /var/www/storage/framework/{cache,sessions,views} /var/www/storage/logs && \
    chown -R www:www /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Install Node.js dependencies
RUN npm install && \
    npm run build && \
    chown -R www:www /var/www/public/build /var/www/node_modules

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Switch to application user
USER www

CMD ["php-fpm"]