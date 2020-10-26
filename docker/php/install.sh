#/usr/sh

docker-php-entrypoint

# composer
php /usr/bin/composer.phar install --prefer-dist -vv

# migrations
php artisan migrate

php-fpm
