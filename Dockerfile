FROM php:8.2-apache

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && find /var/www/html -type d -exec chmod 755 {} \;

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

RUN a2enmod rewrite

RUN rm -f /etc/apache2/mods-available/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-available/mpm_worker.load \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

# FIX: Set DocumentRoot to the public folder
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]