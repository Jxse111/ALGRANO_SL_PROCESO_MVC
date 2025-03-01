FROM php:8.2-apache

# Install dependencies and the mysqli extension
RUN apt-get update && apt-get install -y \
    libmariadb-dev-compat libmariadb-dev && \
    docker-php-ext-install mysqli

# Enable mod_rewrite (optional, if needed)
RUN a2enmod rewrite

# Ensure that the mysqli extension is enabled
RUN php -m | grep mysqli || echo "mysqli not found"