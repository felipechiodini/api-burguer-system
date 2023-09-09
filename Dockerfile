FROM dwchiang/nginx-php-fpm:8.1.18-fpm-alpine3.17-nginx-1.22.1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .
