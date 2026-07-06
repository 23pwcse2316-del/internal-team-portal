FROM php:8.2-apache

# Copy your entire project into the container
COPY . /var/www/html/

# Fix: Apache MPM conflict (disable event, enable prefork for PHP)
RUN a2dismod mpm_event && a2enmod mpm_prefork

# Enable mod_rewrite so .htaccess files work
RUN a2enmod rewrite

# (Optional) Install any PHP extensions you need - uncomment if required
# RUN docker-php-ext-install pdo_mysql mysqli

# Set the working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80