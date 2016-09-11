FROM nginx:latest

MAINTAINER Sascha Brendel <sascha.brendel@ruhr-uni-bochum.de>

ADD nginx.conf /etc/nginx/
ADD attacker.conf /etc/nginx/sites-available/

RUN echo "upstream php-upstream { server php-fpm:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN usermod -u 1000 www-data

CMD ["nginx"]

EXPOSE 80 443
