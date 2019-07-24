FROM php:7.3.6-fpm-alpine3.10
RUN mv ${PHP_INI_DIR}/php.ini-production ${PHP_INI_DIR}/php.ini
RUN docker-php-ext-install -j$(nproc) pdo_mysql
COPY . /app
