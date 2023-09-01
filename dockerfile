#imagem base 
FROM php:8.0-apache
#diretorio 
WORKDIR /var/www/html
#comandos 
RUN docker-php-ext-install pdo_mysql