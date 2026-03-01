# PHP/Apache Service
FROM php:8.2-apache

# Enable Apache modules
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

# Copy PHP application files
COPY ./public/ /var/www/html/

# Copy includes and assets outside the document root to avoid
# nested bind-mount issues (prevents phantom dirs in ./public)
COPY ./includes/ /var/www/includes/
COPY ./assets/ /var/www/assets/

# Apply custom virtual host config (adds /assets alias)
COPY ./docker/php/vhost.conf /etc/apache2/sites-available/000-default.conf

# Set working directory
WORKDIR /var/www/html

# Expose Apache port
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
