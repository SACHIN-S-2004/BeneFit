# PHP/Apache Service
FROM php:8.2-apache

# Enable Apache modules
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

# Copy PHP application files
COPY ../public/ /var/www/html/
COPY ../includes/ /var/www/html/includes/
COPY ../assets/ /var/www/html/assets/

# Set working directory
WORKDIR /var/www/html

# Expose Apache port
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
