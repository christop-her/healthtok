# Use an official PHP runtime
FROM php:7.4-cli

# Install necessary packages and the PostgreSQL PDO extension
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Set the working directory
WORKDIR /var/www/html

# Install Composer dependencies
RUN composer install --no-dev

# Copy the project files into the container
COPY . /var/www/html

# Set permissions for image folders (if applicable)
RUN chmod -R 777 /var/www/html/donation_img /var/www/html/profile_img /var/www/html/blog_img

# Expose the WebSocket port
EXPOSE 8081

# Start the WebSocket server directly
CMD ["php", "/var/www/html/path/to/server.php"]
