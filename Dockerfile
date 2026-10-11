FROM php:8.3-apache

# Habilitar mod_rewrite para las rutas de Argus
RUN a2enmod rewrite

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copiar el proyecto al contenedor
COPY . /var/www/app

# Configurar el directorio público de Apache
RUN rm -rf /var/www/html \
    && ln -s /var/www/app/public /var/www/html

# Directorio de trabajo
WORKDIR /var/www/app

# Permisos para Apache
RUN chown -R www-data:www-data /var/www/app

EXPOSE 80