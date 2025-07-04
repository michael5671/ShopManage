FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql zip

# Enable mod_rewrite (required by Laravel)
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Optional: create appuser matching your host UID/GID to prevent permission issues
ARG UID=1000
ARG GID=1000

RUN groupadd -g ${GID} appgroup \
    && useradd -u ${UID} -g appgroup -m appuser

# Change ownership of /var/www/html to appuser
RUN chown -R appuser:appgroup /var/www/html

# Switch to appuser
USER appuser

# Apache still runs under www-data, but artisan commands from container will use appuser

