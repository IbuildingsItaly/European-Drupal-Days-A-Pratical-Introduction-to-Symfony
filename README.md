# Getting started

- Clone the Project 

- Then

```
$ cd European-Drupal-Days-A-Pratical-Introduction-to-Symfony
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

- When asked, supply the requested information concerning the MySQL database (make sure you run a MySQL server).

- Do whatever is needed to get your file permissions right (see also [Setting up Permissions](http://symfony.com/doc/current/book/installation.html)).

- Then see if everything works:

```
app/console
```

- Create the database and the database schema:

```
app/console doctrine:database:create
app/console doctrine:schema:create
```

- Install [FOSJsRoutingBundle](https://github.com/FriendsOfSymfony/FOSJsRoutingBundle).

- Configure the web server to serve the `/web` directory of this project.

> If you run PHP 5.4 or higher, you don't need to configure the web server for this project, because you can use the
> Symfony command:
>
> ```
> app/console server:run
> ```
>
> Check if everything works. When you request `http://127.0.0.1:8000/` in the browser you should see the "hello page"
> 
> Check your php.ini `http://127.0.0.1:8000/config.php`


### Slides

[Here you can find the slides](http://www.slideshare.net/ibuildingsIT/a-practical-introduction-to-symfony-european-drupal-days-2015)
