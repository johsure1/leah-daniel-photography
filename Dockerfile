FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite

RUN echo '<Directory /var/www/html/>\n\
    AllowOverride All\n\
</Directory>' >> /etc/apache2/apache2.conf

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html/assets/uploads \
    && chmod -R 775 /var/www/html/assets/uploads

EXPOSE 80