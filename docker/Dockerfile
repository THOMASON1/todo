FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y cron && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git unzip

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql

# Install Node.js i npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Debugowanie: wyświetlenie zawartości katalogu przed COPY
# RUN echo "Zawartość katalogu przed COPY:"
# RUN ls -la

# Dodaj crontab
COPY /src/laravel-crontab /etc/cron.d/laravel-crontab

# Nadaj uprawnienia i zainstaluj crontab
RUN chmod 0644 /etc/cron.d/laravel-crontab && \
    crontab /etc/cron.d/laravel-crontab

COPY /src .

EXPOSE 9000
CMD ["sh", "-c", "cron -f & php-fpm"]