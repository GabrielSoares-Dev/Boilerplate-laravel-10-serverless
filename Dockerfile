FROM php:8.1-alpine AS php_stage

RUN apk --no-cache add \
    zip \
    unzip \
    git \
    libzip-dev \
    autoconf \
    g++ \
    make \
    linux-headers

RUN pear update-channels \
    && pecl update-channels \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN docker-php-ext-install pdo_mysql

WORKDIR /app/boilerplate-laravel-10-serverless

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN COMPOSER_ALLOW_SUPERUSER=1

COPY . .


RUN COMPOSER_VENDOR_DIR="/app/boilerplate-laravel-10-serverless/vendor"

RUN composer install --optimize-autoloader --prefer-dist --ignore-platform-reqs


FROM node:18-alpine AS node_stage

WORKDIR /app/boilerplate-laravel-10-serverless

COPY package.json .

RUN npm i

FROM php_stage as server

WORKDIR /app/boilerplate-laravel-10-serverless

COPY --from=php_stage /app/boilerplate-laravel-10-serverless /app/boilerplate-laravel-10-serverless
COPY --from=node_stage /app/boilerplate-laravel-10-serverless /app/boilerplate-laravel-10-serverless

RUN apk --no-cache add nodejs npm


CMD ["sh"]
