FROM php:8.3-fpm-alpine

# Install nginx, composer and required PHP extensions
RUN apk add --no-cache nginx composer php-ctype

# Copy nginx config
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Copy site files
COPY public/ /var/www/html/

# Install PHP dependencies
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Create nginx pid directory
RUN mkdir -p /run/nginx

EXPOSE 80

# Start both php-fpm and nginx
CMD php-fpm -D && nginx -g "daemon off;"
