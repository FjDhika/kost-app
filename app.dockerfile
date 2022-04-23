FROM php:7.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    build-essential \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl
RUN docker-php-ext-configure gd --with-jpeg --with-freetype
RUN docker-php-ext-install gd

COPY composer.lock composer.json /var/www/

COPY database /var/www/database

WORKDIR /var/www

# install php composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN usermod -u 1000 www-data

COPY . /var/www
COPY .env.example /var/www/.env
COPY php/ini/memory_limit.ini /usr/local/etc/php/conf.d/memory-limit-php.ini

# RUN chown -R www-data:www-data \
#         /var/www/storage \
#         /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm", "-F"]

# RUN mv .env.prod .env

# RUN php artisan optimize