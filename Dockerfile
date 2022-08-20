# STAGE 1
FROM php:8.1-fpm
RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl opcache pdo pdo_pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql
WORKDIR /var/www/slim_app
EXPOSE: 9000
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#
## STAGE 2
#FROM nginx:stable-alpine
#RUN rm -rf /etc/nginx/conf.d/*
#COPY nginx/default.conf /etc/nginx/conf.d/
#COPY --from=build /var/www/slim_app /var/www/slim_app
#CMD ["nginx", "-g", "daemon off;"]