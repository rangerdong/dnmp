ARG VERSION=${VERSION}

FROM php:${VERSION}

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
	   libmcrypt-dev \ 
	   libcurl4-openssl-dev \
	   zip \ 
	   unzip \
	   git \
	   procps \
	   wget \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \ 
	&& docker-php-ext-configure curl --with-curl --with-openssl="/usr/openssl/" \
	&& docker-php-ext-install -j$(nproc) gd bz2 pdo_mysql mysqli mbstring opcache shmop curl iconv soap sockets simplexml xml fileinfo opcache zip bcmath 

RUN pecl install mcrypt-1.0.1 && docker-php-ext-enable mcrypt

# enable swoole
ARG SWOOLE_INSTALL=false

RUN if [ ${SWOOLE_INSTALL} = true ]; then \
    cd /tmp \ 
    && git clone https://github.com/swoole/swoole-src.git \
	&& ( \
			cd swoole-src \
			&& phpize \
			&& ./configure --enable-swoole-debug --enable-mysqlnd \
			&& make -j$(nproc) && make install \
			) \
	&& rm -r /tmp/swoole-src \
    && docker-php-ext-enable swoole \
;fi
RUN pecl install yaf &&  docker-php-ext-enable  yaf
RUN pecl install yar && docker-php-ext-enable yar
RUN pecl install seaslog && docker-php-ext-enable seaslog
