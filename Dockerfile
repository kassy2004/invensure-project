
WORKDIR /app


COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build

# -----------------------
# Stage 2: PHP + Laravel
# -----------------------
FROM richarvey/nginx-php-fpm:1.7.2

WORKDIR /var/www/html


# Copy only composer files first
COPY composer.json composer.lock ./

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip \
    && rm -rf /var/lib/apt/lists/*


# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the app
COPY . .

# Copy Vite build from frontend stage
COPY --from=frontend /app/public/build ./public/build

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache


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