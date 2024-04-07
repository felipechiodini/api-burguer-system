FROM wyveo/nginx-php-fpm:php81

ENV TZ="America/Sao_Paulo"

WORKDIR /var/www/html

# RUN apt update && apt install -y php8.0-dev libaio-dev vim cron curl

RUN apt clean && rm -rf /var/lib/apt/lists/*

COPY . .

RUN mv .deploy/default.conf /etc/nginx/conf.d/
#     && mv .deploy/supervisord.conf /etc/ \
#     && mv .deploy/php.ini /etc/php/8.0/fpm/

# RUN (crontab -l ; echo "* * * * * su -c \"php /var/www/html/artisan schedule:run >> /dev/null 2>&1\" -s /bin/bash nginx") | crontab
EXPOSE 80

RUN chown nginx:nginx . -R && chmod 755 -R . && chmod 777 -R storage

RUN composer install --optimize-autoloader --no-dev


