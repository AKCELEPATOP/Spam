FROM php:7.2-fpm
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN ln -sf /usr/share/zoneinfo/Europe/Samara /etc/localtime

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y install git \
                          libpng-dev \
                          zlib1g-dev \
    && docker-php-ext-install bcmath sockets zip \
    && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
