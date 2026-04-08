# syntax=docker/dockerfile:1
FROM php:8.2-cli

WORKDIR /app

# Sistem bağımlılıkları
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev zlib1g-dev libzip-dev libonig-dev sqlite3 libsqlite3-dev \
    && docker-php-ext-install intl pdo pdo_sqlite zip

# Composer (PHP bağımlılıkları için)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Proje dosyalarını kopyala
COPY . .

# PHP bağımlılıklarını yükle
RUN composer install --no-dev --optimize-autoloader

# Port aç
EXPOSE 10000

# Server başlat
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]