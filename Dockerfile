FROM php:8.0.9-alpine
# RUN docker-php-ext-install mysqli
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
COPY . /api


RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/c19391050a3d81f65e61049ebc30dbd4f5a99603/web/installer -O - -q | php -- --quiet 
RUN mv composer.phar /usr/local/bin/composer
RUN apk add git
RUN apk add nano

WORKDIR /api



