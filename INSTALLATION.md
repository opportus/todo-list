# Installation

## Prerequisites

- [Docker](https://docs.docker.com/install/)
- This project on your machine

## Commands

```shell
cd /project

cat docker/dev/mariadb/.secret.env.dist > docker/dev/mariadb/.secret.env
cat app/config/parameters.yml.dist > app/config/parameters.yml

cd docker/dev && docker-compose up -d

docker exec -t todo_list_dev_php_1 /bin/sh -c "apk add --no-cache composer"
docker exec -t todo_list_dev_php_1 /bin/sh -c "cd /app && composer install"
docker exec -t todo_list_dev_php_1 /bin/sh -c "/app/bin/console doctrine:schema:create"
docker exec -t todo_list_dev_php_1 /bin/sh -c "/app/bin/console doctrine:fixtures:load --no-interaction"
```
