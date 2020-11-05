## Setting Database in Local
in `src/settings.php`
```php
// Database Settings
'db' => [
    'host' => 'localhost',
    'user' => 'root', //user disesuaikan 
    'pass' => 'contohPassword', //password disesuaikan
    'dbname' => 'test',
    'driver' => 'mysql'
]
```
## How Run Server in Local
Open Terminal in root project and type `php -S localhost:8002 -t public public/index.php` and go to `http://localhost:8002` in Postman or browser

## Endpoint (in Postman using POST)
* /getUser/{id}
* /getListUser
* /getCompany/{id}
* /getListCompany
* /getBudgetCompany/{id}
* /getListBudgetCompany
* /getLogTransaction
* /createUser
* /updateUser/{id}
* /deleteUser/{id}
* /createCompany
* /updateCompany/{id}
* /deleteCompany/{id}
* /reimburse
* /disburse/
* /close/


# Slim Framework 3 Skeleton Application

Use this skeleton application to quickly setup and start working on a new Slim Framework 3 application. This application uses the latest Slim 3 with the PHP-View template renderer. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    php composer.phar create-project slim/slim-skeleton [my-app-name]

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

To run the application in development, you can run these commands 

	cd [my-app-name]
	php composer.phar start
	
Or you can use `docker-compose` to run the app with `docker`, so you can run these commands:

         cd [my-app-name]
	 docker-compose up -d
After that, open `http://0.0.0.0:8080` in your browser.

Run this command in the application directory to run the test suite

	php composer.phar test

That's it! Now go build something cool.
