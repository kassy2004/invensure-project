# -----------------------
# Stage 1: Build Frontend
# -----------------------
FROM node:18 AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build


# -----------------------
# Stage 2: Build Laravel + PHP
# -----------------------

FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html

COPY . .


# Copy Vite build
COPY --from=frontend /app/public/build ./public/build

# Nginx config
COPY conf/nginx/nginx-site.conf /etc/nginx/sites-enabled/default.conf

# Make PHP-FPM listen on TCP for Nginx
RUN sed -i 's|listen = /var/run/php-fpm.sock|listen = 127.0.0.1:9000|' /usr/local/etc/php-fpm.d/www.conf

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]