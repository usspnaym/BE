# Set the base image for subsequent instructions
FROM php:8.0-fpm

ARG user
ARG uid

# Update packages
RUN apt-get update && \
    apt-get install -qq \
        git \
        curl \
        libonig-dev \
        libxml2-dev \
        libmcrypt-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libbz2-dev \
        libzip-dev \
        libmagickwand-dev \
        zip \
        unzip

# Clear out the local repository of retrieved package files
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

RUN pecl install imagick && \
    docker-php-ext-enable imagick

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user
