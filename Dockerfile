FROM php:8.2.4-apache

# Instalar extensiones
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Copiar el contenido del proyecto al contenedor
COPY . /var/www/html/

# Exponer el puerto 80
EXPOSE 80
