# symfony-project

### How to run the project:
* Clone the repository
```git clone https://github.com/everton-araujo/symfony-project.git```

* Run the server 
```symfony server:start```

* Configure the DB on *.env file*. Mysql root user and without password is the default

* Create the DB
```php bin/console doctrine:database:create```

* Make the migration
```php bin/console make:migration``` and ```php bin/console doctrine:migrations:migrate```

* Open the browser on *localhost:8000*
