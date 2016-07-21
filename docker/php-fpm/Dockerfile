FROM php:7.0-fpm

MAINTAINER Sascha Brendel <sascha.brendel@ruhr-uni-bochum.de>

ADD ./web.ini /usr/local/etc/php/conf.d
ADD ./web.pool.conf /usr/local/etc/php-fpm.d/

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

RUN usermod -u 1000 www-data
WORKDIR /var/www/attacker
CMD ["php-fpm"]

EXPOSE 9000
