FROM debian:jessie

MAINTAINER Franck GAMESS <franck.gamess@gmail.com>

RUN apt-get update && apt-get install -y \
    nginx

ADD nginx.conf /etc/nginx/
ADD tripsorter /etc/nginx/sites-available/

RUN ln -s /etc/nginx/sites-available/tripsorter /etc/nginx/sites-enabled/tripsorter
RUN rm /etc/nginx/sites-enabled/default
RUN rm /etc/nginx/sites-available/default

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN usermod -u 1000 www-data

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
