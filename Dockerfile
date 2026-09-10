FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite headers expires \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
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
