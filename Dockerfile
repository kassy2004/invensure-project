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
# Stage 2: Build PHP App
# -----------------------
FROM php:8.2-fpm AS backend

# Install system packages
RUN apt-get update && apt-get install -y \
    zip unzip git curl nginx \
    libpq-dev \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql

WORKDIR /var/www/html

# Copy app from backend
COPY . .

# Copy Vite build from frontend stage
COPY --from=frontend /app/public/build ./public/build

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# -----------------------
# Configure NGINX
# -----------------------
COPY nginx.conf /etc/nginx/nginx.conf

# Expose http port
EXPOSE 80

CMD service nginx start && php-fpm
