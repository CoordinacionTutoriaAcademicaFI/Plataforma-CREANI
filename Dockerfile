FROM php:8.2-apache

# Extensiones necesarias
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libicu-dev libzip-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_pgsql intl bcmath exif gd zip opcache \
 && a2enmod rewrite headers

# DocumentRoot -> public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf

# php.ini sencillo
RUN { \
  echo 'upload_max_filesize=64M'; \
  echo 'post_max_size=64M'; \
  echo 'memory_limit=512M'; \
  echo 'max_execution_time=120'; \
} > /usr/local/etc/php/conf.d/custom.ini

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
FROM php:8.2-apache

# Extensiones necesarias
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libicu-dev libzip-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_pgsql intl bcmath exif gd zip opcache \
 && a2enmod rewrite headers

# DocumentRoot -> public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf

# php.ini sencillo
RUN { \
  echo 'upload_max_filesize=64M'; \
  echo 'post_max_size=64M'; \
  echo 'memory_limit=512M'; \
  echo 'max_execution_time=120'; \
} > /usr/local/etc/php/conf.d/custom.ini

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
