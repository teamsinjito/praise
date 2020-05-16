FROM php:7.4-fpm

#pdoインストール
RUN docker-php-ext-install pdo_mysql
# RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

#composerインストール
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

#gitインストール
RUN apt-get update
RUN apt-get install -y git

RUN apt-get update \
&& apt-get install -y \
gcc \
make \
libpng-dev \
libmcrypt-dev \
libjpeg-dev \
libfreetype6-dev \
&& docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
&& docker-php-ext-install -j$(nproc) gd