#/usr/sh

docker-php-entrypoint

# composer
php /usr/bin/composer.phar require --prefer-dist -vv
ls -lha

# migrations
php artisan migrate

php-fpm
