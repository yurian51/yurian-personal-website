FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev unzip \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite headers expires \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY composer.json ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader
COPY . /var/www/html
COPY docker/php.ini /usr/local/etc/php/conf.d/zz-production.ini

RUN mkdir -p storage/uploads storage/logs \
    && chown -R www-data:www-data storage \
    && chmod +x docker/entrypoint.sh

COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

HEALTHCHECK --interval=30s --timeout=5s --start-period=20s --retries=3 \
    CMD php -r '$s=@fsockopen("127.0.0.1",80); exit($s ? 0 : 1);'

EXPOSE 80
CMD ["./docker/entrypoint.sh"]
