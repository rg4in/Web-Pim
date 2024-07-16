# Use an official PHP runtime as a parent image
FROM php:7.4-cli

# Set the working directory in the container
WORKDIR /app

# Copy the current directory contents into the container at /app
COPY . /app

# Run PHP's built-in server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
