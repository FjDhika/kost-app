## How to Run For the First Time

-   Please install docker or docker desktop if its not installed on your mechine. you can look it [here](https://docs.docker.com/compose/install/).
-   Clone this repository.
-   Open terminal and change directory to this project. example: `cd kost-app`.
-   Copy paste `.env.example` and rename it to `.env`
-   Run docker with `docker-compose up` or `docker-compose up -d` to run at background.
-   Enter to docker terminal with `docker exec -it app_kost /bin/bash`.
-   Install laravel vendor with `composer install`.
-   Run laravel migration with `php artisan migrate`.
-   Run laravel seeder with `php artisan db:seed`
-   At this point the project already running you can check it at [http://localhost:8990/](http://localhost:8990/).
-   To exit from docker bash use `exit` command.
-   To Stop docker you can use `ctrl+c`, if its running at background you can use `docker-compose stop`.

## Run The App

-   Open terminal
-   Change directory to this project
-   Run docker with `docker-compose up` or `docker-compose up -d` to run at background.
-   At this point the project already running you can check it at [http://localhost:8990/](http://localhost:8990/).
-   To Stop docker you can use `ctrl+c`, if its running at background you can use `docker-compose stop`.

## Run Reset Credit Scheduler

-   Enter docker bash with `docker exec -it app_kost /bin/bash`.
-   Run scheduler with `php artisan scheduler:work`.
-   To exit from docker bash use `exit` command.

## Default User

| No  |         Email          |       Password        | Role    |
| --- | :--------------------: | :-------------------: | ------- |
| 1   |    owner@gmail.com     |    owner@password     | owner   |
| 2   | regular_user@gmail.com | regular_user@password | regular |
| 3   | premium_user@gmail.com | premium_user@password | premium |

## API Documentation

[Postman](https://www.getpostman.com/collections/1daae6cb01ca79c9ae55)
