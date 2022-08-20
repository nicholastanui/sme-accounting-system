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

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#FROM php:7.2-apache
#COPY ../.. /var/www/html/uat-incentive-bundle
#EXPOSE 80
##sed -i -e 's/Listen 80/Listen 80\nServerName localhost/' /etc/apache2/ports.conf
#CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]