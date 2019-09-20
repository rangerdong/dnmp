ARG PHP_CLI_VERSION=${PHP_CLI_VERSION}

FROM php:${PHP_CLI_VERSION}

#Possible values for ext-name:
# bcmath bz2 calendar ctype curl dba dom 
# enchant exif fileinfo filter ftp gd gettext 
# gmp hash iconv imap interbase intl json ldap 
# mbstring mysqli oci8 odbc opcache pcntl pdo pdo_dblib 
# pdo_firebird pdo_mysql pdo_oci pdo_odbc pdo_pgsql pdo_sqlite pgsql 
# phar posix pspell readline recode reflection session shmop simplexml 
# snmp soap sockets sodium spl standard sysvmsg sysvsem sysvshm tidy tokenizer 
# wddx xml xmlreader xmlrpc xmlwriter xsl zend_test zip

RUN apt-get update \
    && apt-get install -y \ 
       libfreetype6-dev \ 
	   libjpeg62-turbo-dev \
	   libbz2-dev \
	   libpng-dev \
	   libxml2-dev \
	   libssl-dev \ 
	   openssl \
	   libssl-dev \
	   libcurl4-openssl-dev \
	   zip \ 
	   unzip \
	   git \
	   procps \
	   wget \
	   cron \ 
	   vim \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \ 
	&& docker-php-ext-configure curl --with-curl --with-openssl="/usr/openssl/" \
	&& docker-php-ext-install -j$(nproc) gd bz2 pdo_mysql mysqli mbstring opcache shmop curl iconv soap sockets simplexml xml fileinfo opcache zip bcmath 

# composer 
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer 


RUN composer config -g repo.packagist composer https://packagist.phpcomposer.com

ARG NPM_INSTALL=false


RUN if [ ${NPM_INSTALL} = true ]; then \
    cd /tmp && wget https://nodejs.org/dist/v6.9.1/node-v6.9.1-linux-x64.tar.xz \
    && xz -d node-v6.9.1-linux-x64.tar.xz \
    && tar -xvf node-v6.9.1-linux-x64.tar \
    && ln -s /tmp/node-v6.9.1-linux-x64/bin/node /usr/bin/node \
    && ln -s /tmp/node-v6.9.1-linux-x64/bin/npm /usr/bin/npm \
;fi


RUN apt-get install  -y supervisor \
	&& echo_supervisord_conf > /etc/supervisord.conf 

COPY supervisord.conf /etc/supervisord.conf

## extensaion crontab ## 
ADD crontab.d/ /var/spool/cron/crontabs/

RUN chown -R root:crontab /var/spool/cron/crontabs/* \
 && chmod -R 600 /var/spool/cron/crontabs/*

RUN pecl install yaf && docker-php-ext-enable  yaf
RUN pecl install yar && docker-php-ext-enable  yar
RUN pecl install seaslog && docker-php-ext-enable  seaslog

 
ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

WORKDIR /var/www

