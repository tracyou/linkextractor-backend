setup:
	@make down
	@make up
	@docker-compose exec api composer install
	@docker-compose exec api sh -c 'echo "Waiting for database connection..."'
	@make db-fresh
	@docker-compose exec api php artisan key:generate
	@docker-compose exec api php artisan ide-helper:meta
	@docker-compose exec api php artisan ide-helper:generate
	@docker-compose exec api php artisan ide-helper:eloquent
	@docker-compose exec api php artisan passport:install
	@docker-compose exec api php artisan storage:link
	@make ide-helper-lighthouse

up:
	@docker-compose up -d

down:
	@docker-compose down --remove-orphans

db-fresh:
	@docker-compose exec api php artisan migrate:fresh
	@docker-compose exec api php artisan db:seed

destroy:
	@make down --volumes

ssh:
	@docker-compose exec api sh

test:
	@docker-compose -f docker-compose-test.yml up -d
	@docker-compose -f docker-compose-test.yml exec api-test php artisan key:generate --force
	@docker-compose -f docker-compose-test.yml exec -T -e APP_ENV=testing api-test sh -c "vendor/bin/phpunit ./tests $PARAMETERS --coverage-text --coverage-clover coverage/coverage.xml --colors=never --stderr"

ide-helper:
	@docker-compose exec api php artisan ide-helper:model --reset --write
	@docker-compose exec api php artisan enum:annotate

ide-helper-lighthouse:
	@docker-compose exec api php artisan lighthouse:ide-helper
	@docker-compose exec api sh -c 'sed -i "s/repeatable//g" schema-directives.graphql'
