# Use an official PHP runtime with Apache 
FROM php:7.4-cli

# Install necessary packages and the PostgreSQL PDO extension
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Set the working directory
WORKDIR /var/www/html

# Copy the project files into the container
COPY . /var/www/html

# Set permissions for all image folders to be writable
RUN chmod -R 777 /var/www/html/donation_img /var/www/html/profile_img /var/www/html/blog_img

# Declare volumes to persist images
VOLUME ["/var/www/html/profile_img", "/var/www/html/donation_img", "/var/www/html/blog_img"]

# Expose ports for the WebSocket servers
EXPOSE 8081 8082 8083

# Use Supervisor to manage both Apache and the WebSocket servers
RUN apt-get update && apt-get install -y supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Start Supervisor
CMD ["supervisord"]
