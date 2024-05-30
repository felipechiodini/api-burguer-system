FROM php:8.2.18-fpm-alpine

ENV TZ="America/Sao_Paulo"

WORKDIR /var/www/html

RUN apk update
RUN apk add bash
RUN apk add curl
RUN apk add nginx
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

COPY . .

# RUN mv .deploy/default.conf /etc/nginx/conf.d/default.conf
#     && mv .deploy/supervisord.conf /etc/ \
#     && mv .deploy/php.ini /etc/php/8.0/fpm/

# RUN (crontab -l ; echo "* * * * * su -c \"php /var/www/html/artisan schedule:run >> /dev/null 2>&1\" -s /bin/bash nginx") | crontab
# RUN chown nginx:nginx . -R && chmod 755 -R . && chmod 777 -R storage

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer 

#RUN composer install --optimize-autoloader --no-dev
