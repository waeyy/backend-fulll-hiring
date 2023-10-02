# Requirements
To run this project you will need a computer with PHP and composer installed.

# Install
To install the project, you just have to run `composer install` to get all the dependencies

# Setup database
Update line 19 of Fulll\Infra\Doctrine\ORM\EntityManager with your needs.
```php
->parse('mysqli://root@127.0.0.1:3306/fulll_hiring?serverVersion=5.7.28')
```

# Running commands
```shell
php bin/app fleet:create <userId> 
php bin/app fleet:vehicle:register <fleetId> <vehiclePlateNumber>
php bin/app fleet:vehicle:localize <fleetId> <vehiclePlateNumber> <lat> <lng> 
```

# Running the tests
```shell
make test
```
The result should look like this :
![behat.png](behat.png)


# Running ci and test
Will run PHP-CS-Fixer, PHPCS and PHPStan for tracking basic issues and bugs following coding standards.
```shell
make ci
```
