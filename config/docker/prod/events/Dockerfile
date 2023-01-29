
FROM somnambulist/php-ppm:8.0-latest
ENV TERM=xterm-256color

RUN apk --update add ca-certificates \
    && apk update \
    && apk upgrade \
    && apk --no-cache add -U \
    php81-pdo_pgsql \
    php81-pgsql \
    php81-pecl-amqp \
    && rm -rf /var/cache/apk/* /tmp/*

# setup custom PHP ini files
COPY config/docker/prod/events/conf.d/zz-custom.ini /etc/php81/conf.d/

WORKDIR /app

COPY config/docker/prod/events/docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod 755 /docker-entrypoint.sh

COPY composer.* ./
COPY .env* ./

RUN composer install --no-scripts --quiet --optimize-autoloader && rm -rf /tmp/*

COPY . .

CMD ["/docker-entrypoint.sh"]
