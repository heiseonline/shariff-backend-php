FROM php:7.1-fpm-alpine

ADD https://getcomposer.org/composer.phar /usr/bin/composer
RUN chmod +x /usr/bin/composer

ADD composer.json composer.lock /var/www/shariff/

RUN cd /var/www/shariff \
    && composer install

ADD . /var/www/shariff

RUN cd /var/www/shariff \
    && composer dump-autoload \
    && ./build.sh \
    && cp -r build/. /var/www/html/ \
    && rm -r /var/www/shariff
