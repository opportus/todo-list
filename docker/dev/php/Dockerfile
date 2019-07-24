FROM php:7.3.6-fpm-alpine3.10

# Sets default development PHP configuration
RUN mv ${PHP_INI_DIR}/php.ini-development ${PHP_INI_DIR}/php.ini

# Sets PHP configuration
COPY ./docker/dev/php/config/php.conf ${PHP_INI_DIR}/conf.d/php.ini

# Installs pdo_mysql extension
RUN docker-php-ext-install -j$(nproc) pdo_mysql

# Copies the application directory
COPY . /app
