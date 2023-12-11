FROM php:8.2-cli-alpine

# COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN composer install

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000" , "-t", "public/"]
