FROM php:7.2-fpm

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
	   libcurl4-openssl-dev \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \ 
	&& docker-php-ext-configure curl --with-curl --with-openssl="/usr/openssl/" \
	&& docker-php-ext-install -j$(nproc) gd bz2 pdo_mysql mysqli mbstring opcache shmop curl iconv soap sockets simplexml xml fileinfo opcache
# composer 

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer 