#!/bin/sh -x

DOCKER_COMPOSE_CMD="docker-compose -f docker-compose-test.yml"
PARAMETERS=$*
APP_KEY="base64:M2FmbnRza2F6d3l5cjFoenk0aWs5MG96dnptbGZnczE="

${DOCKER_COMPOSE_CMD} down --volumes --remove-orphans

${DOCKER_COMPOSE_CMD} up -d

${DOCKER_COMPOSE_CMD} exec -T -e APP_ENV=testing api-test ./scripts/wait-for.sh database-test:5432 -t 60 -- echo "Database connection established"
${DOCKER_COMPOSE_CMD} exec -T -e APP_ENV=testing api-test composer install

EXIT_CODE=$?

${DOCKER_COMPOSE_CMD} down --volumes --remove-orphans

exit ${EXIT_CODE}
