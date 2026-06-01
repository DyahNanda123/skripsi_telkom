# Tahap 1: Build Frontend (Vite/Tailwind)
FROM node:20 AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Tahap 2: Setup PHP & Apache Server
FROM php:8.3-apache

ENV TZ=Asia/Jakarta

# Install dependensi sistem & ekstensi PHP lengkap (termasuk GD untuk gambar)
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libonig-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip gd

# Aktifkan Mod_Rewrite Apache (Wajib untuk Laravel)
RUN a2enmod rewrite

# Ubah DocumentRoot Apache supaya menghala terus ke folder /public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja
WORKDIR /var/www/html

# Salin semua fail kod ke dalam container
COPY . .

# Salin hasil build Vite dari Tahap 1
COPY --from=frontend /app/public/build ./public/build

# Install pustaka PHP (Optimized & No Dev untuk Production)
RUN composer install --optimize-autoloader --no-dev

# Berikan keizinan tulis (write access) untuk folder storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# ==========================================
# SKRIP STARTUP: Auto Migrate & Storage Link
# ==========================================
RUN echo '#!/bin/bash\n\
php artisan storage:link\n\
php artisan migrate --force\n\
apache2-foreground' > /usr/local/bin/start-app.sh

# Jadikan skrip boleh dilaksanakan (executable)
RUN chmod +x /usr/local/bin/start-app.sh

# Buka Port 80
EXPOSE 80

# Jalankan skrip ini setiap kali kontena (container) dihidupkan
CMD ["/usr/local/bin/start-app.sh"]