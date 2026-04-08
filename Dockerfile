# Stage 0: PHP + gerekli paketler
FROM php:8.2-cli

# Sistem bağımlılıkları
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev zlib1g-dev libzip-dev libonig-dev sqlite3 libsqlite3-dev \
    && docker-php-ext-install intl pdo pdo_sqlite zip

# Çalışma dizini
WORKDIR /app

# Uygulama dosyalarını kopyala
COPY . .

# var/cache ve var/log dizinlerini oluştur ve izin ver
RUN mkdir -p var/cache var/log var/data && chmod -R 777 var

# Composer kur (Render prod modda zaten olabilir ama emin ol)
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Composer install
RUN composer install --no-dev --optimize-autoloader

# Prod mod cache oluştur ve DB schema
RUN php bin/console doctrine:database:create --env=prod || true
RUN php bin/console doctrine:schema:create --env=prod || true
RUN php bin/console cache:clear --env=prod

# Server çalıştır
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]