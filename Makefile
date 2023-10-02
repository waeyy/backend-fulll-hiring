EXEC_PHP = php

ci: php-cs-fixer phpcs phpstan test

test:
	 $(EXEC_PHP) vendor/behat/behat/bin/behat

phpcs:
	$(EXEC_PHP) vendor/bin/phpcs --standard=PSR12 src/

php-cs-fixer:
	$(EXEC_PHP) vendor/bin/php-cs-fixer fix --verbose

php-cs-fixer.dry-run:
	$(EXEC_PHP) vendor/bin/php-cs-fixer fix --verbose --diff --dry-run

phpstan:
	$(EXEC_PHP) vendor/bin/phpstan analyse
