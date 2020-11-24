[![Build Status](https://travis-ci.com/vitorhugoro1/basic-laravel-jwt-api.svg?branch=master)](https://travis-ci.com/vitorhugoro1/basic-laravel-jwt-api)
# Basic Laravel JWT API

This is an basic Laravel project, with capabilities like JWT (Json Web Token) using [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth) lib to control this.

## How to run

This project is make to run with **Docker** or direct with your self structure. The docker images is from project sustained by **CODECASTS** images to PHP+NGINX. To run this project:

```bash
docker-compose up -d
```

```bash
docker-compose exec app composer install
```

To generate database:

```bash
docker-compose exec app php artisan migrate
```

To run tests:

```bash
docker-compose exec app ./vendor/bin/phpunit
```

To stop:

```bash
docker-compose stop
```
