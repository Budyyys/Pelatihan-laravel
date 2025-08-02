# Gunakan base image PHP 8.2-FPM-Alpine
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Instal dependensi sistem yang diperlukan
RUN apk add --no-cache \
    build-base \
    git \
    unzip \
    mariadb-dev \
    libzip-dev \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    curl

# Instal ekstensi PHP yang esensial
RUN docker-php-ext-install \
    pdo_mysql \
    opcache \
    bcmath \
    zip

# Instal Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin file composer terlebih dahulu untuk memanfaatkan Docker layer caching
COPY composer.json composer.lock ./

# Jalankan composer install untuk dependensi produksi
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Salin semua file aplikasi
COPY . .

# Jalankan composer scripts yang mungkin diperlukan
RUN composer run-script post-autoload-dump

# Atur izin file yang benar
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Buat direktori yang diperlukan jika belum ada
RUN mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/storage/framework/cache/data \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views

# Konfigurasi PHP-FPM
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.enable_cli=0" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=4000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.revalidate_freq=60" >> /usr/local/etc/php/conf.d/opcache.ini

# Expose port 9000 untuk PHP-FPM
EXPOSE 9000

# Tetapkan user untuk menjalankan PHP-FPM
USER www-data

# Perintah default untuk menjalankan php-fpm
CMD ["php-fpm"]
