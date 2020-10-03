
FROM somnambulist/php-ppm:7.4-latest
ENV TERM=xterm-256color

RUN apk --update add ca-certificates \
    && apk update \
    && apk upgrade \
    && apk --no-cache add -U \
    php7-pdo_pgsql \
    php7-pgsql \
    php7-pecl-amqp \
    && rm -rf /var/cache/apk/* /tmp/*

# setup custom PHP ini files
COPY config/docker/dev/events/conf.d/zz-custom.ini *user.ini /etc/php7/conf.d/

WORKDIR /app

COPY config/docker/dev/events/docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod 755 /docker-entrypoint.sh

COPY composer.* ./
COPY .env* ./

RUN composer install --no-suggest --no-scripts --quiet && rm -rf /tmp/*

COPY . .

CMD ["/docker-entrypoint.sh"]
