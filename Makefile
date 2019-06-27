# Help
TARGETS:=$(MAKEFILE_LIST)

.PHONY: help
help: ## This help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(TARGETS) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

# Tests

.PHONY: test
test: cs phpstan
test-ci: test ui-test check_security

ui-test: vendor ## Run ui tests
	./vendor/bin/phpunit --testdox --group=ui

.PHONY: check_security
check_security: ## Check for dependency vulnerabilities
	curl -H "Accept: text/plain" https://security.symfony.com/check_lock -F lock=@composer.lock

# Coding Style

.PHONY: cs cs-fix cs-ci
cs: vendor ## Check code style
	./vendor/bin/phpcs

cs-fix: vendor ## Fix code style
	./vendor/bin/phpcbf

cs-ci: vendor ## Run Continuous Integration code style check
	./vendor/bin/phpcs

# Static Analysis

.PHONY: phpstan
phpstan: vendor ## Check static analysis
	./vendor/bin/phpstan analyse src tests --level=max

# Project

.PHONY: install
install: vendor

vendor: composer.json composer.lock
	composer install

.PHONY: start
start: .web-server-pid

.web-server-pid: vendor ## Starts the server
	php vendor/bin/console server:start 127.0.0.1:8080

.PHONY: stop
stop: vendor ## Stop the server
	php vendor/bin/console server:stop
