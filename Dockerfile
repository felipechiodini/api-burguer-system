FROM wyveo/nginx-php-fpm:php82

ENV TZ="America/Sao_Paulo"

WORKDIR /var/www/html

COPY . .

RUN mv .deploy/default.conf /etc/nginx/conf.d/ \
    && mv .deploy/supervisord.conf /etc/
    # && mv .deploy/php.ini /etc/php/8.0/fpm/

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --optimize-autoloader --no-dev

# RUN chown nginx:nginx . -R && chmod 755 -R . && chmod 777 -R storage

# RUN (crontab -l ; echo "* * * * * su -c \"php /var/www/html/artisan schedule:run >> /dev/null 2>&1\" -s /bin/bash nginx") | crontab