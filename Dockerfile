# Dockerfile
FROM php:8.2-apache

# Instala a extensão pdo_mysql para conexão com MySQL
RUN docker-php-ext-install pdo_mysql

# Instala e habilita o Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Habilita o mod_rewrite no Apache
RUN a2enmod rewrite

# Configuraçõers do Xdebug
RUN echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >>  /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=docker" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_log=/app/storage/logs/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.default_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini


# Instala as dependências necessárias para o Composer
RUN apt-get update && apt-get install -y curl unzip git

# Instala o Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia o código da API para o diretório padrão do Apache
COPY . /var/www/html

# Define as permissões corretas para o diretório
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copiar o arquivo php.ini
COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www/html