vendor/bin/php-cs-fixer fix --dry-run --diff
vendor/bin/phpstan analyse src tests

bin/console cache:clear
bin/console cache:clear --env=test
vendor/bin/phpunit  --filter ContractServiceTest
vendor/bin/phpunit  --filter ContractControllerTest