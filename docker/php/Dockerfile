FROM php:8.4-cli

# System dependencies for GD
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Redis PHP extension
RUN pecl install redis \
    && docker-php-ext-enable redis

WORKDIR /var/www