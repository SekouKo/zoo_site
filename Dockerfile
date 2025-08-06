# Dockerfile
FROM php:8.1-apache

# Active mod_rewrite 
RUN a2enmod rewrite

# Installe les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Copie le code dans le conteneur
COPY . /var/www/html/

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/html
