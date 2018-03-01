FROM php:7.2-fpm-alpine3.7 

ADD https://getcomposer.org/composer.phar /usr/bin/composer
RUN chmod +x /usr/bin/composer

ADD composer.json composer.lock /var/www/shariff/

RUN cd /var/www/shariff \
    && composer install

ADD . /var/www/shariff

RUN cd /var/www/shariff \
    && ./build.sh \
    && cp -r build/. /var/www/html/ \
    && rm -r /var/www/shariff
