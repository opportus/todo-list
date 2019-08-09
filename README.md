[![Codacy Badge](https://api.codacy.com/project/badge/Grade/7ba4610e19684301b0cec8f043b215ea)](https://app.codacy.com/app/opportus/todo-list?utm_source=github.com&utm_medium=referral&utm_content=opportus/todo-list&utm_campaign=Badge_Grade_Dashboard)
[![Build Status](https://travis-ci.com/opportus/todo-list.svg?branch=master)](https://travis-ci.com/opportus/todo-list)
[![SymfonyInsight](https://insight.symfony.com/projects/ca529f46-56b2-4584-bf1f-9811bab1c89b/mini.svg)](https://insight.symfony.com/projects/ca529f46-56b2-4584-bf1f-9811bab1c89b)

## Attached Resources

- [Test coverage report](https://github.com/opportus/todo-list/tree/master/app/Resources/report/test-coverage)
- [MVP performance audit report](https://github.com/opportus/todo-list/blob/master/app/Resources/report/mvp-performance-audit.pdf)
- [Upgrade performance audit report](https://github.com/opportus/todo-list/blob/master/app/Resources/report/upgrade-performance-audit.pdf)
- [MVP - Upgrade comparison performance audit report](https://github.com/opportus/todo-list/blob/master/app/Resources/report/mvp-upgrade-comparison-performance-audit.pdf)
- [Code quality audit report](https://github.com/opportus/todo-list/blob/master/app/Resources/report/code-quality-audit.pdf)
- [Sprints](https://github.com/opportus/todo-list/projects)
- [Authentication documentation](https://github.com/opportus/todo-list/blob/master/app/Resources/doc/authentication.pdf)
- [Contribution guide](https://github.com/opportus/todo-list/blob/master/CONTRIBUTING.md)
- [Installation guide](#installation)

## Installation

### Prerequisites

- [Get Docker](https://docs.docker.com/install/)
- [Download Todo List](https://github.com/opportus/todo-list/archive/master.zip) and extract it

### Commands

```shell
# Set your working directory to the root of the previously downloaded and extracted Todo List project...
cd /path/to/project

# Set up your local MariaDB Docker service secrets...
cat docker/dev/mariadb/.secret.env.dist > docker/dev/mariadb/.secret.env

# Set up your local Blackfire Docker service secrets...
cat docker/dev/blackfire/.secret.env.dist > docker/dev/blackfire/.secret.env

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
