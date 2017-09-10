# Temperature Unit Converter

Recruitment task from [phorzycki/recruitment](https://github.com/phorzycki/recruitment).

## Converting temperatures
### Console
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

### API
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
            "F": 97.88,
            "K": 309.75
        }
    }
}
```

### Front
You can convert temperatures using user-friendly front app via address:
```
http(s)://{host}/
```

## Requirements
* PHP 7.1.3 or higher
* Composer
* NPM 5.3 or higher

## Development

### Installation
1. Clone repository
2. Configuration
You need to create `.env` file, which contains all the necessary environment variables that application needs. You can
 create it by following command (in folder where you cloned this project):

```bash
cp .env.dist .env
```

Then open that file and make necessary changes to it. Note that this `.env` file is ignored on VCS.
3. Dependencies installation
Next phase is to install all needed dependencies. This you can do with following commands, in your project folder:

```bash
composer install
npm install
```

4. Run assets watcher & local PHP server

```bash
php bin/console server:start # will run PHP server in background
npm run watch # will run npm in foreground
```

### Formatting code
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

### Running tests
This project contains unit tests in [PHPUnit](https://phpunit.de/) with config file (**phpunit.xml**). To run it you
 have to execute command:

```bash
./vendor/bin/phpunit --config phpunit.xml
```

## Author
[Paweł Cierzniakowski](mailto:pawel@cierzniakowski.pl)