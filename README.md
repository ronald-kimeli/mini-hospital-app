Mini Hospital Management 
==========================

A full-stack application on laravel api and vue js frontend with bootstrap css. Mini management of the hospital services like reception and treatment.

Table of Contents
-----------------

* [Requirements](#requirements)
* [Features](#features)
* [Installation](#installation)
* [Usage](#usage)

Requirements
------------


* [PHP 8.2+][php]
* [Laravel 11][laravel]
* [MySQL][mysql]
* [Node.js 16+][node]
* [Vite][vite]
* [Vue 3][vue]


[php]: https://www.php.net/releases/
[laravel]: https://laravel.com/docs/11.x/installation
[mysql]: https://www.mysql.com/
[node]: https://nodejs.org
[vite]: https://vitejs.dev
[vue]: https://vuejs.org


Features
--------

- Create, retrieve all, retrieve a specific, update, and delete hospital records.
- Validate incoming requests with custom validation rules.
- Search hospital records by patient name, record status, and appointment date.
- Utilize Eloquent relationships and provide structured controller responses.


Installation
------------

Clone this repository and create .env file through copy

```bash
cp .env.example .env
```

Provide database credentials below in .env file for postgres.

```php
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=Enter_database_name
    DB_USERNAME=Enter_database_user_name
    DB_PASSWORD=Enter_database_password
```
  
Install project dependencies, key generate and clear cached config

```php
composer install && php artisan key:generate && php artisan optimize
```
Now seed db with dummy data and start the server.

```php
php artisan migrate --seed && php artisan serve 
```

Install nodejs dependencies and run the server

```javascript
npm install && npm run dev
```

Laravel will run on port 8000 and node most likely 5173 or 3000

```php
localhost:8000 || localhost:5173
```

Usage
------------

**Login Credentials**
   - **Email**: admin@gmail.com
   - **Password**: 12345678















