# Defome um valor padrão para a versão do PHP caso não seja passado
ARG PHP_VERSION=8.3.20-fpm-alpine3.20

FROM php:${PHP_VERSION}

ARG USER_NAME
ARG UID=1000
ARG GID=1000
# Adiciona o nome do projeto recebido com compose ou define o padrão como `app`
ARG PROJECT_NAME=app

# Diretório da aplicação
ENV APP_DIR="/var/www/${PROJECT_NAME}"

# --------------------------------------------------------------
# Instalação de dependências do sistema operacional
# --------------------------------------------------------------

# Alpine usa apk em vez de apt-get
RUN apk update && apk add --no-cache \
    supervisor \
    zlib-dev \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    unzip \
    postgresql-dev \
    curl \
    make \
    gnu-libiconv-dev \
    oniguruma-dev \
    sqlite-dev

# --------------------------------------------------------------
# EXTENSÕES DO PHP
# --------------------------------------------------------------    

# Install core database extensions
RUN docker-php-ext-install mysqli pdo_mysql 

# Install SQLite extensions
RUN docker-php-ext-install pdo_sqlite 

# Install PostgreSQL extensions
RUN docker-php-ext-install pdo_pgsql pgsql

# Install standard extensions
RUN docker-php-ext-install zip simplexml pcntl gd fileinfo mbstring xml session

# --------------------------------------------------------------    
# Instala a última versão do Composer para o PHP
# --------------------------------------------------------------    
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# --------------------------------------------------------------
# Prepara as configurações customizadas do PHP da pasta `/.docker/php`
# --------------------------------------------------------------
COPY ./.docker/php/php.ini "$PHP_INI_DIR/conf.d/99_extra.ini"
COPY ./.docker/php/php-fpm.conf /usr/local/etc/php-fpm.d

# --------------------------------------------------------------
# Prepara o usuário - para resolver problemas de permissão ao alterar arquivos
# --------------------------------------------------------------
RUN addgroup -g ${GID} ${USER_NAME} \
    && adduser -D -u ${UID} -G ${USER_NAME} -s /bin/sh -h /home/${USER_NAME} ${USER_NAME}

# --------------------------------------------------------------
WORKDIR $APP_DIR

# Copia os arquivos do composer.json e composer.lock para dentro do container
COPY --chown=${USER_NAME}:${USER_NAME} composer* .

# Altera o proprietário e o grupo do diretório da aplicação - definido pela variável $APP_DIR
RUN chown ${USER_NAME}:${USER_NAME} $APP_DIR

# Copio tudo que está na pasta src para dentro do container usando o usuário
COPY --chown=${USER_NAME}:${USER_NAME} . .

# Remove as dependências antigas do composer
# RUN [ -d "vendor" ] && rm -rf vendor || true
# RUN composer install --no-interaction


# --------------------------------------------------------------
# Cria alias para executar o comando do Composer
# Alias `cmp` que executa o comando `composer`
# --------------------------------------------------------------
RUN echo '#!/bin/sh' > /usr/local/bin/cmp && \
    echo 'composer "$@"' >> /usr/local/bin/cmp && \
    chmod +x /usr/local/bin/cmp

# --------------------------------------------------------------

    
EXPOSE 8080

USER $USER_NAME
