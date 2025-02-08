# Usar la imagen oficial de PHP sin FPM
FROM php:8.0-cli

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql

# Copiar el código fuente de la aplicación al contenedor
COPY ./src /var/www/html

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Exponer el puerto 8080
EXPOSE 8080

# Ejecutar el servidor web de PHP en el puerto 8080
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/var/www/html"]

