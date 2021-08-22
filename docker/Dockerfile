FROM php:8-apache

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip sqlite3 libsqlite3-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu xdebug \
    && docker-php-ext-enable apcu xdebug \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip intl pdo pdo_mysql
RUN mkdir /db
RUN /usr/bin/sqlite3 /db/test.db
RUN echo 'xdebug.mode=develop,debug,coverage' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.discover_client_host=true' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo 'xdebug.log=/var/log/xdebug.log' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo 'xdebug.start_with_request=trigger' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo 'short_open_tag = Off' >> /usr/local/etc/php/conf.d/docker-php-config.ini \
 && echo 'date.timezone = Europe/Madrid' >> /usr/local/etc/php/conf.d/docker-php-config.ini \
 && a2enmod rewrite headers\
 && curl -sS https://getcomposer.org/installer \
   | php -- --install-dir=/usr/local/bin --filename=composer \
 && echo "AllowEncodedSlashes On" >> /etc/apache2/apache2.conf

COPY docker/symfony.conf /etc/apache2/sites-enabled/000-default.conf

RUN curl -sS https://get.symfony.com/cli/installer | bash \
 && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www
RUN chmod 777 /var/log/xdebug.log

EXPOSE 80
CMD ["apachectl", "-D", "FOREGROUND"]