# Installation

## Prerequisites

- [Get Docker](https://docs.docker.com/install/)
- [Download Todo List](https://github.com/opportus/todo-list/archive/master.zip) and extract it

## Commands

```shell
# Set your working directory to the root of the previously downloaded and extracted Todo List project...
cd /path/to/project

# Set up your local MariaDB Docker service secrets...
cat docker/dev/mariadb/.secret.env.dist > docker/dev/mariadb/.secret.env

# Set up your local Symfony parameters...
cat app/config/parameters.yml.dist > app/config/parameters.yml

# Set your working directory as follow...
cd docker/dev

# Run Docker services...
docker-compose up -d

# Install Composer in your Docker PHP service...
docker exec -t todo_list_dev_php_1 /bin/sh -c "apk add --no-cache composer"

# Install Todo List dependencies via Composer in your Docker PHP service...
docker exec -t todo_list_dev_php_1 /bin/sh -c "cd /app && composer install"

# Set up Todo List database schema via Symfony console in your Docker PHP service...
docker exec -t todo_list_dev_php_1 /bin/sh -c "/app/bin/console doctrine:schema:create"

# Set up Todo List database data via Symfony console in your Docker PHP service...
docker exec -t todo_list_dev_php_1 /bin/sh -c "/app/bin/console doctrine:fixtures:load --no-interaction"
```

You're done.