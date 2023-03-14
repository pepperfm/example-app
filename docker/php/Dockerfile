FROM php:8.2-fpm

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

ARG DOCKER_GROUP_ID
ARG DOCKER_USER_ID

USER root

RUN usermod -u ${DOCKER_USER_ID} -d /var/www/example-app www-data && \
    groupmod -g ${DOCKER_GROUP_ID} www-data

# Fix user permissions
RUN mkdir -p /var/www/example-app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chown www-data:www-data /usr/local/bin && \
    chmod 755 /usr/local/bin

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        zip \
        unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql exif

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install php-memcached \
        php8.2-mysql php8.2-pgsql php8.2-pdo php8.2-pdo_mysql php-redis php8.2-sqlite3 php-xdebug \
        php8.2-bcmath php8.2-bz2 php8.2-dba php8.2-redis \
        php8.2-enchant php8.2-gd php8.2-gmp php-igbinary php-imagick php8.2-imap \
        php8.2-intl php8.2-ldap php-mongodb php-msgpack php8.2-soap php-ssh2 \
        php8.2-sybase php-tideways php8.2-tidy php8.2-xmlrpc php8.2-xsl \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \

USER www-data

COPY composer.json composer.json

RUN composer i \
   --no-interaction \
   --no-plugins \
   --no-scripts \
   --no-dev \
   --prefer-dist

COPY . .

# Fix user permissions
RUN chown -R www-data:www-data /var/www/example-app && \
    chmod 755 /var/www/example-app

RUN composer dump-autoload

RUN php artisan key:generate
RUN php artisan storage:link

CMD [ "php-fpm" ]
