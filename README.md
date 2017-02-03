# Algolia example application

[![Build Status](https://travis-ci.org/nebez/algolia-app.svg?branch=master)](https://travis-ci.org/nebez/algolia-app) [![Coverage Status](https://coveralls.io/repos/github/nebez/algolia-app/badge.svg)](https://coveralls.io/github/nebez/algolia-app)

[Front-end preview](http://nebezb.com/algolia-app/)

### Installation

1. Clone the repository
    * `git clone https://github.com/nebez/algolia-app`
2. Move into the project and install the dependencies
    * `cd algolia-app`
    * `composer install`
3. Create an `.env` file for your application credentials
    * `cp .env.example .env`

### Test suite / code coverage

You can start the test suite by running `composer test`. This command also produces an HTML code coverage report in `./report`.

### Running the server

Run the command below from the project root (not the `/public` folder) and browse to [localhost:8080](http://localhost:8080/)

```
php -S 0.0.0.0:8080 -t public/ public/server.php
```
