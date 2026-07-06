FROM php:8.4-apache

# Install system dependencies, Node.js (for Vite), and SQLite
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_sqlite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy all application files
COPY . .

# Install PHP dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --no-dev --optimize-autoloader

# ✅ FIX: Install tailwindcss/forms then build Vite assets
RUN npm install \
    && npm install -D @tailwindcss/forms \
    && npm run build

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Configure .env, create SQLite DB, generate key, and run migrations
RUN touch .env \
    && echo "APP_ENV=production" >> .env \
    && echo "APP_DEBUG=false" >> .env \
    && echo "DB_CONNECTION=sqlite" >> .env \
    && echo "SESSION_DRIVER=file" >> .env \
    && mkdir -p database \
    && touch database/database.sqlite \
    && chmod 666 database/database.sqlite \
    && php artisan key:generate --no-interaction --force \
    && php artisan migrate --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Copy custom startup script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Remove conflicting MPM modules
RUN rm -f /etc/apache2/mods-available/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-available/mpm_worker.load \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load

# Set ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Point DocumentRoot to public folder
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]