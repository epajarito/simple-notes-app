## Simple notes app made with Laravel

In this app im show you my abilities with the laravel framework, from routes,controllers, form request, and a little markup with html and API REST too. 

## Installation

We need to use composer for install dependencies

```
composer install
```

## Create .env file

```
cp .env.example.env
```

## Configure the database (in this case i use mysql)

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my-database-name
DB_USERNAME=my-user
DB_PASSWORD=my-password
```

## Run migrations

```
php artisan migrate --seed 
```

## Run project locally
```
php artisan serve
```
