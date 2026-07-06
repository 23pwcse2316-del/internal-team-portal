FROM php:8.2-apache

# Copy your application files
COPY . /var/www/html/

# Set proper ownership and permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && find /var/www/html -type d -exec chmod 755 {} \;

# Copy the custom startup script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Make the script executable
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Enable mod_rewrite
RUN a2enmod rewrite

# Remove conflicting MPM files
RUN rm -f /etc/apache2/mods-available/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-available/mpm_worker.load \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load

# Add ServerName to suppress the FQDN warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set the working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80

# Override the default command to use our startup script
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]