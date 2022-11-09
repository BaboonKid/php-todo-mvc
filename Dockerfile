FROM php:8-apache

RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql

# Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --quiet \
    && mv composer.phar /usr/local/bin/composer \
    && rm composer-setup.php