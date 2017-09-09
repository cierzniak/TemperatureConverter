# Temperature Unit Converter

Recruitment task from [phorzycki/recruitment](https://github.com/phorzycki/recruitment).

### Converting temperatures
#### Console
You can convert temperatures using CLI interface via console command:

```bash
php bin/console app:converter {value} {unit}
```

Example output:

```
Temperatura -100C w innych jednostkach ma wartość:
* -100C
* -148F
* 173.15K
```

#### API
You can convert temperatures using API interface via address:
```
http(s)://{host}/api/v1/converter/{value}/{unit}
```

Example output:

```
{
    "data": {
        "entered": {
            "C": 36.6
        },
        "converted": {
            "C": 36.6,
            "F": 97.88000000000005,
            "K": 309.75
        }
    }
}
```

### Development

#### Formatting code
This project contains [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) config file (**.php_cs**). To run it
 on every commit you have to add it as Git hook (as executable bash script):

```bash
composer global require friendsofphp/php-cs-fixer
echo "#\!/usr/bin/env bash
git status --porcelain | grep -e '^[AM]\(.*\).php$' | cut -c 3- | while read line; do
  php-cs-fixer fix "\$line" --config=.php_cs --allow-risky=yes
  git add "\$line"
done" > ./.git/hooks/pre-commit
chmod +x ./.git/hooks/pre-commit
```

#### Running tests
This project contains unit tests in [PHPUnit](https://phpunit.de/) with config file (**phpunit.xml**). To run it you
 have to execute command:

```bash
./vendor/bin/phpunit --config phpunit.xml
```

### Author
[Paweł Cierzniakowski](mailto:pawel@cierzniakowski.pl)