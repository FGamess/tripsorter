FROM php:7.1-fpm

### Install some requirements
RUN apt-get update && apt-get install -y git zlib1g-dev libmcrypt-dev supervisor openssh-server \
    --no-install-recommends \
    && mkdir -p /var/log/supervisor \
    && mkdir -p /var/run/sshd \
    && rm -rf /var/lib/apt/lists/* 

#Add composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN compose --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"

# install xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.cli_color=1\nxdebug.remote_autostart=1\nxdebug.remote_connect_back=1" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


#COPY supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY php.ini /tmp/php.ini_extension
RUN cat /tmp/php.ini_extension >> /usr/local/etc/php/php.ini \
    && rm /tmp/php.ini_extension

#COPY php-fpm.conf /usr/local/etc/php-fpm.conf

RUN usermod -u 1000 www-data

WORKDIR /var/www/

# Make ssh dir
RUN mkdir /root/.ssh/

