FROM php:8.1-fpm-alpine3.14

ENV TZ=Europe/Moscow
ENV LANG ru_RU.utf8
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apk update && apk add libpq postgresql-dev curl-dev libpng-dev libxml2-dev autoconf build-base supervisor git bash openssh-client-default sudo mc openssl-dev
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer
RUN docker-php-ext-install pdo pdo_pgsql curl gd dom sockets

RUN apk add --update linux-headers
RUN pecl install xdebug
RUN echo "zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20210902/xdebug.so" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.start_upon_error=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ARG UID

RUN mkdir -p /home
RUN addgroup -g ${UID} oem
RUN adduser --disabled-password -h /home/oem -s /bin/bash oem -u ${UID} -G oem
RUN echo "oem ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

RUN mkdir -p /var/www
RUN chown -R oem:root /var/run/ /var/log/ /opt
RUN chown -R oem:oem /home/oem/

ENV PHP_IDE_CONFIG serverName=localhost
ENV XDEBUG_CONFIG client_host=host.docker.internal mode=debug start_with_request=yes start_upon_error=yes client_port=9003
RUN mkdir -p /run/php/ && chown -R oem:root /run/php/

COPY entrypoint.cli.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

WORKDIR /var/www
USER oem

ENTRYPOINT [ "/entrypoint.sh" ]

