FROM php:8.2-apache

# Copy your entire project
COPY . /var/www/html/

# Copy custom Apache MPM config
COPY mpm.conf /etc/apache2/mods-available/mpm_prefork.conf

# Enable mod_rewrite
RUN a2enmod rewrite

# Force Apache to use only mpm_prefork
RUN a2dismod mpm_event || true && \
    a2dismod mpm_worker || true && \
    a2enmod mpm_prefork

# Set working directory
WORKDIR /var/www/html

EXPOSE 80