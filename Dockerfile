#
# Stage 1: Frontend build
#
FROM node:20 AS frontend

WORKDIR /app

COPY package*.json ./
COPY vite.config.js .
COPY postcss.config.js .
COPY tailwind.config.js .
COPY resources ./resources

RUN npm install \
 && npm run build

# -----------------------
# Stage 2: PHP + Laravel
# -----------------------
FROM richarvey/nginx-php-fpm:1.7.2

WORKDIR /var/www/html

# Copy composer files first
COPY composer.json composer.lock ./

# Install PHP extensions here (PHP stage only)
RUN apk add --no-cache \
    zip unzip libzip-dev oniguruma-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Set composer memory & allow superuser
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_ALLOW_SUPERUSER=1


# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader 

# Copy the rest of the app
COPY . .

# Copy Vite build from frontend stage
COPY --from=frontend /app/public/build ./public/build

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

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]