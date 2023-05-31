<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Simple E-commerce with Notifications using web-sockets and Laravel Queues

# Technologies used
- Backend: PHP, Laravel , MySQL, Web-sockets
- Frontend: HTML5 , CSS , Bootstrap 5, Vanilla Javascript, Vuexy Admin Template

# Followed Pattern
- Action Pattern : Single Action classes to handle business logic


# Pre-requisites
- Install [PHP](https://www.php.net/downloads.php) version 8.1 or greater
- Install [NodeJs](https://nodejs.org/en/) version 16 or greater
- Install [Composer](https://getcomposer.org/download/) version 2.1 or greater
- Install [MySQL](https://www.mysql.com/downloads/) version 8.0 or greater


# Getting started
- Clone the repository
```
git clone  https://github.com/MahmoudNehro/Simple-Ecommerce.git
```
- Install dependencies
```
composer install

npm install
```
- Create a copy of your .env file
```
cp .env.example .env
```
- Generate an app encryption key
```
php artisan key:generate
```
- Create an empty database for our application
- In the .env file, add database information
```
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
- For the web-sockets server, add the following to the .env file, the web socket uses pusher keys but doesn't use pusher server, it uses Laravel echo server, the keys can be anything, just unique for each project on your machine
```
PUSHER_APP_ID=12345
PUSHER_APP_KEY=12345
PUSHER_APP_SECRET=12345
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1
```
- Make sure the following is in the .env file
```
BROADCAST_DRIVER=pusher
```
- For the queue configuration make sure the following is in the .env file

```
QUEUE_CONNECTION=database
```
- Migrate the database with seeder
```
php artisan migrate --seed
```
- Run the development server
```
php artisan serve
```
- Run the queue worker
```
php artisan queue:work
```
- Run the web-sockets server
```
php artisan websockets:serve
```
- Compile the assets
```
npm run dev
```
- Or you can build the assets
```
npm run build
```
- Visit [http://localhost:8000](http://localhost:8000) or [http://127.0.0.1:8000](http://127.0.0.1:8000)

admin credentials:
```
email: admin@admin.com
password: 12345678
```
