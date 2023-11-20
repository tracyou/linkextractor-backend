setup:
	@make down
	@make up
	@docker-compose exec api composer install
	@docker-compose exec api sh -c 'echo "Waiting for database connection..."'
	@docker-compose exec api ./scripts/wait-for.sh database:5432 -t 120 -- echo "Database connection established"
	@make db-fresh
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
	@docker-compose exec api php artisan test

ide-helper:
	@docker-compose exec api php artisan ide-helper:model --reset --write
	@docker-compose exec api php artisan enum:annotate

ide-helper-lighthouse:
	@docker-compose exec api php artisan lighthouse:ide-helper
	@docker-compose exec api sh -c 'sed -i "s/repeatable//g" schema-directives.graphql'
