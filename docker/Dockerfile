FROM php:8.3-fpm-alpine

# Install nginx
RUN apk add --no-cache nginx

# Copy nginx config
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Copy site files
COPY public/ /var/www/html/

# Create nginx pid directory
RUN mkdir -p /run/nginx

EXPOSE 80

# Start both php-fpm and nginx
CMD php-fpm -D && nginx -g "daemon off;"
