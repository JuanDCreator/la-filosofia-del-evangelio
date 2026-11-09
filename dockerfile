FROM php:8.3-apache

# Instalar la extensión necesaria para MySQL.
RUN docker-php-ext-install pdo_mysql

# Copiar los archivos del proyecto.
COPY . /var/www/html/

# Activar módulos de Apache.
RUN a2enmod rewrite

# Puerto del servidor web.
EXPOSE 80