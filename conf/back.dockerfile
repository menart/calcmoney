FROM php:7-fpm 

RUN apt-get update && \
    apt-get install -y libxml2-dev libpq-dev freetds-dev libxrender-dev libfontconfig libxext-dev libmemcached-dev zlib1g-dev \
     libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev && \
    ln -s /usr/lib/x86_64-linux-gnu/libsybdb.so.5 /usr/lib/libsybdb.so && \
    docker-php-ext-install soap pdo_pgsql bcmath pdo_dblib xmlrpc && \
    pecl install xdebug-2.9.0 && \
    pecl install memcached-3.1.4 && \
    docker-php-ext-enable memcached && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd

RUN mkdir -p /var/log/testcase && chmod 777 /var/log/testcase -R
