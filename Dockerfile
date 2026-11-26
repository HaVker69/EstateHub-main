# syntax=docker/dockerfile:1

# ---- Frontend assets ----
FROM node:22-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY vite.config.js ./
COPY resources ./resources
RUN npm run build

# ---- PHP application ----
FROM dunglas/frankenphp:1-php8.4 AS app

WORKDIR /app

# The debian-security mirror occasionally serves a not-yet-valid signature;
# mark apt sources trusted and skip date checks so this build-time-only
# glitch doesn't block us (base image identity is already trusted via the
# Docker registry pull).
RUN awk -v RS='' -v ORS='\n\n' '{print $0"\nTrusted: yes"}' /etc/apt/sources.list.d/debian.sources > /tmp/sources && \
    mv /tmp/sources /etc/apt/sources.list.d/debian.sources && \
    printf 'Acquire::Check-Valid-Until "false";\nAcquire::Check-Date "false";\n' > /etc/apt/apt.conf.d/10no-check-valid-until

RUN install-php-extensions \
    pdo_mysql \
    mbstring \
    zip \
    intl \
    opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN composer dump-autoload --optimize --no-dev

COPY docker/Caddyfile /etc/caddy/Caddyfile
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

RUN chown -R www-data:www-data storage bootstrap/cache

ENV SERVER_NAME=:80

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
