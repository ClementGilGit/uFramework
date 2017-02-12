Project Made by PELMOINE Rémi & GIL Clément
===========================================

Here is a tutotrial how to install and run our project.

---------------------------------
Install all the dependencies
================================
```bash
    composer install
```

---------------------------------
Install a Docker
====================
```bash
    docker run -d \
    --volume /var/lib/mysql \
    --name data_mysql \
    --entrypoint /bin/echo \
    busybox \
    "mysql data-only container"
```

---------------------------------
Run a SQL Container
===================

```bash
    docker run -d -p 3306 \
    --name mysql \
    --volumes-from data_mysql \
    -e MYSQL_USER=uframework \
    -e MYSQL_PASS=p4ssw0rd \
    -e ON_CREATE_DB=uframework \
    tutum/mysql
```

---------------------------------
Find the port
============

```bash
    docker ps
```

---------------------------------
Replace the port
================

```bash
In "app.php" replace the $port with the port of docker ps
```
Then run:

```bash
    mysql uframework -h127.0.0.1 -P<port> -uuframework -pP4ssW0rd < app/config/schema.sql
```

If you want to stop the container, you can execute the following command:

``` bash
$docker stop mysql # or its ID
```

To start the container again:

``` bash
$docker start mysql # or its ID
```

**Important:** if you want to run the MySQL container again, you have to run the
following command:

``` bash
$ docker run -d -p 3306 \
    --volumes-from data_mysql \
    tutum/mysql
```

---------------------------------
Launch our Server
====================

```bash
    php -S localhost:8080 -t web/
```


---------------------------------
Testing
=======
Run tests

```bash
    php phpunit
```

---------------------------------
Tasks achieved
==============

+ Routes
+ Request & Response
+ Composer
+ DataBase using DataMapper & DataFinder
+ Authentification
+ Firewall
+ Validation
+ Docker
+ Tests
+ Design (Bootstrap)
