For starting the Backend:

You should have xampp already installed and this should be in xampp/htdocs/[project-name] folder
you should create a database
Run:
composer install
Open PhpMyAdmin( or mysql from command line)
create database named 
copy .env.example to .env and type database credentials
then run:
php artisan migrate:fresh
php artisan passport:client --personal
php artisan install passport

Instead of doing all these you can use our Server on heroku:
https://photo-sharing-back-end.herokuapp.com

