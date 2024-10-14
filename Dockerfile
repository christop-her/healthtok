# Use an official PHP runtime with Apache 
FROM php:7.4-apache

# Install necessary packages and the PostgreSQL PDO extension
RUN apt-get update && apt-get install -y \
    libpq-dev \
    supervisor \
    zip unzip curl \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy the project files into the container
COPY . /var/www/html

# Install PHP dependencies using Composer
RUN composer install --no-dev

# Set permissions for all image folders to be writable
RUN chmod -R 777 /var/www/html/donation_img /var/www/html/profile_img /var/www/html/blog_img

# Declare volumes to persist images
VOLUME ["/var/www/html/profile_img", "/var/www/html/donation_img", "/var/www/html/blog_img"]

# Expose ports for the WebSocket servers
EXPOSE 8083

# Copy the Supervisor configuration file
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Start Supervisor
CMD ["supervisord"]
