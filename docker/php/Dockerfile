FROM php:7.3.4-fpm-alpine3.9

LABEL maintainer="ffeliciodeveloper@gmail.com"

ENV EXTENSION \
    zip \
    mbstring \
    pdo \
    pdo_mysql \
    xml \
    xmlrpc \
    json \
    opcache \
    phar \
    readline \
    sockets \
    tokenizer \
    xsl \
    intl \
    mysqli \
    soap

RUN apk update && apk add --no-cache \
    alpine-sdk \
    autoconf \
    git \
    mysql-client \
    curl \
    curl-dev \
    freetds-dev \
    mc \
    libmcrypt \
    libmcrypt-dev \
    libxml2-dev \
    freetype \
    freetype-dev \
    libpng \
    libpng-dev \
    jpeg-dev \
    libjpeg-turbo \
    libxslt-dev \
    libjpeg-turbo-dev g++ make autoconf \
    && rm /var/cache/apk/*

RUN docker-php-source extract && \
    pecl install xdebug redis opcache && \
    docker-php-ext-enable xdebug redis opcache && \
    docker-php-source delete && \
    docker-php-ext-install \
      bcmath calendar curl dom fileinfo hash json mbstring \
      mysqli pdo pdo_dblib pdo_mysql sockets xml xsl \
    && echo "xdebug.remote_enable=on\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=on\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9000\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_handler=dbgp\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=1\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN docker-php-ext-configure gd \
        --with-gd \
        --with-freetype-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
      && apk del --no-cache freetype freetype-dev libpng libpng-dev libjpeg-turbo libjpeg-turbo-dev \
      && rm -rf /tmp/*

# Change TimeZone
RUN echo "Set default timezone - America/Sao_Paulo" \
    echo "America/Sao_Paulo" > /etc/timezone

# Install composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

COPY php.ini /usr/local/etc/php/

RUN rm -f /usr/local/etc/php-fpm.d/www.conf.default
ADD php-fpm.conf /usr/local/etc/php-fpm.d/
RUN rm -f /usr/local/etc/php-fpm.d/www.conf

RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

USER www-data

## Let's set the working dir
WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]