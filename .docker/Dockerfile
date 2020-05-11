FROM php:7.3-fpm-stretch

WORKDIR /app

RUN mkdir app

# Set your timezone here
RUN rm /etc/localtime \
    && ln -s /usr/share/zoneinfo/Europe/Vilnius /etc/localtime

# Setup PHP modules
RUN apt-get -q update \
    && apt-get install -y zlib1g-dev libpng-dev libicu-dev libzip-dev libmemcached-dev git zip unzip wget curl

RUN pecl install apcu

RUN docker-php-ext-enable apcu \
 && docker-php-ext-configure intl \
 && docker-php-ext-install intl mbstring pdo pdo_mysql zip gd


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#COPY ./ /app

RUN PATH=$PATH:/app/vendor/bin:bin

# Install Nginx in the same container
RUN apt-get update && apt install nginx -y
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY .docker/nginx/vhost.conf /etc/nginx/sites-enabled/default

# Install and Setup xDebug
RUN apt-get update \
# Add "ip" tools for resolve "host.docker.internal" through entrypoint automatically, because there is no suport "for-linux" at this time (@see https://github.com/docker/for-linux/issues/264)
    && apt-get -y install iproute2 \
    && apt-get -y install iputils-ping \
    && pecl install xdebug-2.9.3 \
    && docker-php-ext-enable xdebug \
    && touch /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "error_reporting=E_ALL" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    # Full path to xdebug.so -> =/usr/local/lib/php/extensions/no-debug-non-zts-20151012/xdebug.so
    && echo "zend_extension=xdebug.so" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.default_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.profiler_enable=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.profiler_output_dir=\"/var/www/html\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.collect_includes = 0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.collect_params = 0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.collect_return = 0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.collect_vars = 0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.coverage_enable = 0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    #&& echo "xdebug.max_nesting_level = 100" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.overload_var_dump = 2" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#CMD ["/bin/bash","-c","( nginx -g 'daemon off;' & ) && php-fpm -F"]
