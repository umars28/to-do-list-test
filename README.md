# README #

## What is this repository for? ##

* Simple To Do List Apps

## How do I get set up? ##

### Environments ###
* Laravel: 9
* PHP : 8.1
* MySQL: 8.0

### Run Application ###
* Open terminal / cmd
* use command `composer install` to Install Composer Dependencies
* use command `cp .env.example .env` to Create a copy of your .env file if env file not generated yet
* use command `php artisan key:generate` to Generate an app encryption key
* use command `php artisan migrate` to Migrate the database
* use command `php artisan db:seed` to init dummy data


### Run This Command if jwt token secret not working yet ###
* use command `php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"`
* use command `php artisan jwt:secret` to Generate secret jwt token on env
