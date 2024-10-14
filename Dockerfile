# Use a lightweight PHP runtime
FROM php:7.4-cli

# Install necessary packages
RUN apt-get update && apt-get install -y libpq-dev supervisor \
    && docker-php-ext-install pdo pdo_pgsql

# Set the working directory
WORKDIR /var/www/html

# Install PHP dependencies (assuming composer.json is present)
RUN composer install --no-dev

# Copy the project files into the container
COPY . /var/www/html

# Expose port for WebSocket server
EXPOSE 8081

# Copy Supervisor configuration
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Start Supervisor to manage WebSocket server
CMD ["supervisord"]
