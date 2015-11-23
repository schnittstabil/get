.PHONY: lint phpunit test

test: lint phpunit

lint:
	@tput setaf 2; echo running lint...; tput sgr0
	@vendor/bin/php-cs-fixer fix --dry-run --diff Schnittstabil
	@vendor/bin/php-cs-fixer fix --dry-run --diff tests

phpunit:
	@tput setaf 2; echo running phpunit...; tput sgr0
	@vendor/bin/phpunit
