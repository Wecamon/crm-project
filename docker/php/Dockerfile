FROM php:8.1-fpm-alpine
RUN apk upgrade && apk add --no-cache \
    linux-headers\
    shadow\
    gcc\
    make\
    g++\
    zlib-dev\
    curl-dev\
    libidn2-dev\
    libevent-dev\
    icu-dev\
    libidn-dev\
    oniguruma-dev\
    libtool\
    composer\
    autoconf\
    libc6-compat\
    postgresql-client\
    postgresql-dev\
    php8-pecl-redis\
    php8-session\
    php8-xml\
    php8-ctype\
    php8-tokenizer\
    php8-sodium\
    php8-curl\
    php8-gd\
    php8-mbstring\
    php8-xsl\
    php8-pear\
    php8-intl

RUN docker-php-ext-install\
        pdo\
        pdo_pgsql\
\
&&  pecl install xdebug\
&&  docker-php-ext-enable xdebug\
\
&& echo "error_reporting=E_ERROR" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "display_startup_errors=Off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "display_errors=Off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.log_level=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.discover_client_host=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN usermod -u 1000 www-data

RUN mkdir /var/www/.opcache/
RUN chmod 777 /var/www/.opcache/

RUN echo "opcache.file_cache_only=1;" >> /usr/local/etc/php/conf.d/opcache.ini
RUN echo "opcache.file_cache_consistency_checks=1;" >> /usr/local/etc/php/conf.d/opcache.ini
RUN echo "opcache.file_cache=/var/www/.opcache/;" >> /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/app
COPY . . 
RUN ls

CMD ["php-fpm"]