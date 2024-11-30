# Step 1: Use an official PHP image as the base image
FROM php:8.1-apache

# Step 2: Enable mod_rewrite for Apache (for clean URLs if needed)
RUN a2enmod rewrite

# Step 3: Set working directory
WORKDIR /var/www/html

# Step 4: Copy application files into the container
COPY . /var/www/html/

# Step 5: Install additional PHP extensions (such as gd for image manipulation)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Step 6: Enable MySQLi extension (if not already enabled by default)
RUN docker-php-ext-install mysqli

# Step 7: Set permissions for Apache to access the files
RUN chown -R www-data:www-data /var/www/html

# Step 8: Expose port 80 for the application
EXPOSE 80

# Step 9: Set the entry point to run Apache in the foreground
CMD ["apache2-foreground"]
