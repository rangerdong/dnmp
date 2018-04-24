ARG MYSQL_VERSION=latest
FROM mysql:${MYSQL_VERSION}

ARG TZ=UTC
ENV TZ ${TZ}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN chown -R mysql:root /var/lib/mysql/

COPY my.cnf /etc/mysql/conf.d/my.cnf


#RUN mkdir -p /var/lib/mysql-files /var/run/mysqld
#RUN chown -R mysql:mysql /var/lib/mysql-files /var/run/mysqld && chmod 777 /var/lib/mysql-files /var/run/mysqld
CMD ["mysqld"]

EXPOSE 3306