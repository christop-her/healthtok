# Use an official PHP runtime with Apache
FROM php:7.4-apache

# Install necessary packages and the PostgreSQL PDO extension
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Set the working directory
WORKDIR /var/www/html

# Copy project files into the container
COPY . /var/www/html

# Install PHP dependencies via Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev

# Set permissions for all image folders to be writable
RUN chmod -R 777 /var/www/html/donation_img /var/www/html/profile_img /var/www/html/blog_img

# Declare volumes to persist images
VOLUME ["/var/www/html/profile_img", "/var/www/html/donation_img", "/var/www/html/blog_img"]

# Expose ports for WebSocket servers
EXPOSE 8083

# Install Supervisor
RUN apt-get update && apt-get install -y supervisor

# Copy Supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Start Supervisor
CMD ["supervisord"]
