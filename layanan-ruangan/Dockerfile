# ===== STAGE 1: Dependencies Build =====
FROM php:8.2-fpm-alpine AS dependencies

# Set working directory
WORKDIR /var/www/html

# Install only essential build dependencies
RUN apk add --no-cache --virtual .build-deps \
    build-base \
    mariadb-dev \
    libzip-dev \
    oniguruma-dev \
    && apk add --no-cache \
    git \
    unzip

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    opcache \
    bcmath \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files for dependency caching
COPY composer.json composer.lock ./

# Install dependencies with all packages (including dev)
RUN composer install \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction \
    --prefer-dist \
    && composer clear-cache

# ===== STAGE 2: Production Build =====
FROM php:8.2-fpm-alpine AS production

# Set working directory
WORKDIR /var/www/html

# Install only runtime dependencies (smaller footprint)
RUN apk add --no-cache \
    mariadb-client \
    libzip \
    && rm -rf /var/cache/apk/*

# Copy PHP extensions from dependencies stage
COPY --from=dependencies /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=dependencies /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Install Composer in production stage for development
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy vendor from dependencies stage
COPY --from=dependencies /var/www/html/vendor /var/www/html/vendor

# Copy application files (exclude unnecessary files)
COPY --chown=www-data:www-data . .

# Regenerate autoload in production mode without dev packages
RUN composer dump-autoload --optimize --classmap-authoritative

# Remove development files and optimize
RUN rm -rf \
    .git \
    .gitignore \
    .gitattributes \
    .editorconfig \
    .env.example \
    README.md \
    tests \
    phpunit.xml \
    webpack.mix.js \
    package.json \
    package-lock.json \
    node_modules \
    && find . -name "*.md" -type f -delete \
    && find . -name ".DS_Store" -type f -delete

# Create necessary directories with correct permissions
RUN mkdir -p storage/logs \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Optimize PHP configuration
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.enable_cli=0'; \
    echo 'opcache.memory_consumption=64'; \
    echo 'opcache.interned_strings_buffer=4'; \
    echo 'opcache.max_accelerated_files=2000'; \
    echo 'opcache.revalidate_freq=60'; \
    echo 'opcache.fast_shutdown=1'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

# Expose port 9000 untuk PHP-FPM
EXPOSE 9000

# Switch to non-root user
USER www-data

# Command to run PHP-FPM
CMD ["php-fpm"]
