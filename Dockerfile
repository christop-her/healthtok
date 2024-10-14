# Use an official PHP runtime with Apache 
FROM php:7.4-apache

# Install necessary packages and the PostgreSQL PDO extension
RUN apt-get update && apt-get install -y libpq-dev supervisor \
    && docker-php-ext-install pdo pdo_pgsql

# Set the working directory
WORKDIR /var/www/html

# Copy the project files into the container
COPY . /var/www/html

# Set permissions for image folders (if applicable)
RUN chmod -R 777 /var/www/html/donation_img /var/www/html/profile_img /var/www/html/blog_img

# Copy the Supervisor configuration file
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose the WebSocket port and Apache port
EXPOSE 8081

# Start Supervisor
CMD ["supervisord", "-n"]
