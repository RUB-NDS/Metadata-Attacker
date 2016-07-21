FROM php:7.0-fpm

MAINTAINER Sascha Brendel <sascha.brendel@ruhr-uni-bochum.de>

ADD ./web.ini /usr/local/etc/php/conf.d
ADD ./web.pool.conf /usr/local/etc/php-fpm.d/


RUN apt-get update && apt-get install -y \
		exiftool \
    && rm -r /var/lib/apt/lists/*


RUN usermod -u 1000 www-data

WORKDIR /var/www/attacker

CMD ["php-fpm"]

EXPOSE 9000
