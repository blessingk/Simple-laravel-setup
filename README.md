## About the project

The purpose of this project is to send birthday wishes to all employees who are currently working at Realm Digital

## How to run the project
1. Clone the project and run the following commands 
```
cd realmTest
composer install
cp .env.example .env and modify email configurations. For local development use https://mailtrap.io/
php artisan key:generate
```
2. Navigate to http://127.0.0.1:8000/birthdays
3. Check the inbox you should receive some birthday wishes
4. Birthday wishes can also be sent by running the command below in the project directory
```birthday command
php artisan birthday:wish
```

## Project structure
This project uses a birthday service as below:
```
app/Services 
│   Birthday.php
```
Test Can be found in the following directory:
```
tests/Feature
│  BirthdayTest.php
```
