# ─────────────────────────────────────────────
# Stage 1: Build frontend assets
# ─────────────────────────────────────────────
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci

COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources/ resources/
COPY public/ public/

RUN npm run build

# ─────────────────────────────────────────────
# Stage 2: PHP application
# ─────────────────────────────────────────────
FROM php:8.2-fpm-alpine AS app

# System dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        gd \
        zip \
        bcmath \
        intl \
        opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for layer caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --optimize-autoloader --no-interaction

# Copy application source
COPY . .

# Copy built frontend assets from stage 1
COPY --from=node-builder /app/public/build public/build

# Laravel setup
RUN cp .env.example .env \
    && php artisan key:generate --force \
    && php artisan config:clear \
    && php artisan storage:link || true

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy config files
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf
COPY docker/php/php.ini $PHP_INI_DIR/conf.d/app.ini
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
