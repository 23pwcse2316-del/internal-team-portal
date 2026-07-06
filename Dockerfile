FROM php:8.2-apache

# Copy your application files
COPY . /var/www/html/

# Copy the custom startup script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Make the script executable
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Enable mod_rewrite
RUN a2enmod rewrite

# Remove the conflicting MPM load files during build (just to be safe)
RUN rm -f /etc/apache2/mods-available/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-available/mpm_worker.load \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load

# Set the working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80

# Override the default command to use our startup script
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]