FROM php:8.0.12-fpm-alpine

RUN apk update \
 && apk add --no-cache $PHPIZE_DEPS \
    bash \
    git \
    zip \
    unzip \
    rsyslog \
    tzdata \
    zlib-dev \
    libxml2-dev \
    libzip-dev

RUN touch /var/log/schedule.log
RUN chmod 0777 /var/log/schedule.log
#RUN echo $(ls)

ADD crontab /etc/crontabs/root

RUN docker-php-ext-install pdo_mysql mysqli zip

RUN apk add icu-dev
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-enable intl

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_host=192.168.10.249" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN adduser -D -u 1000 docker && echo "docker:docker" | chpasswd

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

ENV TIMEZONE=UTC
RUN ln -s /usr/share/zoneinfo/$TIMEZONE /etc/localtime && echo $TIMEZONE > /etc/timezone
RUN "date"

CMD crond -b && rsyslogd && php-fpm

#RUN chmod 777 -R public/

RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN apk add vim
RUN alias sc="symfony console"
