#!/usr/bin/env bash

cd /app

# Set correct file permissions
chown -R www-data:www-data vendor/
chown -R www-data:www-data var/
chown -R www-data:www-data web/media

# Set cache & logs folder permissions
chmod a+rwx var/cache/ -R
chmod a+rwx var/logs/ -R

echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

# Initialize the database
#php bin/console doctrine:database:create --no-interaction --if-not-exists

php bin/console doctrine:migrations:migrate --no-interaction || true
php bin/console doctrine:cache:clear-metadata
php bin/console doctrine:cache:clear-query
php bin/console doctrine:cache:clear-result
php bin/console cache:clear --env="${APP_ENV}"

# DEV environment
ENV="${APP_ENV:-dev}"
if [ "$ENV" = "dev" ]; then
  # Access host from a docker container through "host.docker.internal" (@see https://dev.to/bufferings/access-host-from-a-docker-container-4099)
  HOST_DOMAIN="host.docker.internal"
  ping -q -c1 HOST_DOMAIN > /dev/null 2>&1;
  if [[ $? -ne 0 ]]; then
      HOST_IP=$(ip route | awk 'NR==1 {print $3}');
      echo -e "$HOST_IP\t$HOST_DOMAIN" | tee -a /etc/hosts;
  fi
fi

( nginx -g 'daemon off;' & ) && php-fpm -F
