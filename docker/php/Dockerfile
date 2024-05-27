FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libpq-dev \
    supervisor \
    vim \
    cmake

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install CMake.
# RUN wget -O - https://apt.kitware.com/keys/kitware-archive-latest.asc 2>/dev/null | gpg --dearmor - | tee /etc/apt/trusted.gpg.d/kitware.gpg >/dev/null && \
#     apt-add-repository 'deb https://apt.kitware.com/ubuntu/ jammy main' && \
#     apt update && apt install -y cmake

# Install Couchbase PHP extension
RUN pecl install couchbase-4.1.6

# Enable Couchbase PHP extension
# RUN docker-php-ext-enable couchbase.so
RUN echo 'extension=couchbase.so' >> /usr/local/etc/php/php.ini-development \
    && echo 'extension=couchbase.so' >> /usr/local/etc/php/php.ini-production \
	&& echo 'extension=couchbase.so' >> /usr/local/etc/php/conf.d/docker-fpm.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
# COPY . .

COPY entrypoint.sh /entrypoint.sh

# Set permissions
RUN chown -R www-data:www-data /var/www

# USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
ENTRYPOINT [ "/entrypoint.sh" ]
CMD ["php-fpm"]