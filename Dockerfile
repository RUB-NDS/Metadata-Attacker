FROM php:7.3-apache

MAINTAINER Sascha Brendel <code@lednerb.de>

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

# Download and install composer
ADD ./get-composer.sh /usr/local/bin
RUN cd /usr/local/bin \
    && bash ./get-composer.sh \
    && mv composer.phar composer \
    && chmod +x composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# RUN  sed -i -e "s/html/html\/app/g" /etc/apache2/sites-enabled/000-default.conf

USER www-data

WORKDIR /var/www
COPY --chown=www-data:www-data . .

RUN composer install
RUN vendor/bin/phpunit

USER root

EXPOSE 80
CMD ["apache2-foreground"]
