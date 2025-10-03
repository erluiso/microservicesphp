FROM php:7.4-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get install curl -y
RUN a2enmod rewrite
EXPOSE 8080/tcp
EXPOSE 8080/udp