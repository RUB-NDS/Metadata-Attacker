FROM php:7.0-apache

MAINTAINER Sascha Brendel <sascha.brendel@ruhr-uni-bochum.de>

#Install necessary tools and components
RUN apt-get update && apt-get install -y \
        build-essential \
        wget \
        libgcrypt11-dev \
        zlib1g-dev \
        mercurial \
        autoconf \
        automake \
    && rm -r /var/lib/apt/lists/*

# Download, build and install latest version of AtomicParsley
WORKDIR /tmp
RUN hg clone https://bitbucket.org/wez/atomicparsley \
    && cd atomicparsley \
    && ./autogen.sh  \
    && ./configure \
    && make \
    && make install 

# Download and install phpunit
RUN wget https://phar.phpunit.de/phpunit.phar \
    && chmod +x phpunit.phar \
    && mv phpunit.phar /usr/local/bin/phpunit \
    && phpunit --version

# Download and install composer
ADD ./get-composer.sh /usr/local/bin
RUN cd /usr/local/bin \
    && bash ./get-composer.sh \
    && mv composer.phar composer \
    && chmod +x composer
ENV COMPOSER_ALLOW_SUPERUSER=1

ADD . /var/www/

WORKDIR /var/www
RUN composer install

WORKDIR /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]