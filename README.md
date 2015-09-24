Vinted homework
========================

to compile application, and its dependencies, at main project folder execute command with composer:

    php patch/to/composer.phar update

when you need to input application parameters just left defaults

To output shipment prices at main project folder execute:

    php app/console vinted:shipment

Input data file you can find in src/AppBundle/Resources/data/input.txt
Provides data file you can find in src/AppBundle/Resources/data/providers.txt

Change input.txt file path you can at src/AppBundle/Resources/config/services.yml

All Rules is located at src/AppBundle/Rules folder
Rules configuration is at src/AppBundle/config/config.json (rules are applied by the order in config file)

PHP Unit Tests can be run by command:

    php phpunit.phar -c app src/AppBundle/