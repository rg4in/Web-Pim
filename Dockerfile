# Use the official PHP image from Docker Hub
FROM php:7.4-cli

# Set the working directory inside the container
WORKDIR /app

# Copy all files from the current directory to /app inside the container
COPY . /app

# Install the mysqli extension for PHP
RUN docker-php-ext-install mysqli

# Set environment variables for MySQL connection
ENV MYSQL_HOST=localhost
ENV MYSQL_USERNAME=root
ENV MYSQL_DATABASE=lovepotion_db

# Set the command to run the PHP server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
