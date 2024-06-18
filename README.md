## TODOLIST APP

## TABLE OF CONTENTS

  1. INTRODUCTION
  2. FEATURES
  3. REQUIREMENTS
  4. CONFIGURATION
  5. INSTALLATION
  6. USAGE

## INTRODUCTION

  This is ToDoList App developed using Laravel as the backend and Vue.js as the frontend.

## FEATURES

  1. User authentication
  2. Add task
  3. Update task status
  4. Delete task

## REQUIREMENTS

  PHP >= [8.2.12]
  composer >= [2.7.7]
  Nodejs >= [v22.3.0]
  NPM >= [10.8.1]
  MySQL

## CONFIGURATION

  configure database connection in [.env] files:

    APP_KEY=base64:YmiCAqUZnVnyBjyLCpMhp+J3as/1As+lGKmnyeVSD2o=

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=test_linghowaun
    DB_USERNAME=root
    DB_PASSWORD=

## INSTALLATION

  git clone https://github.com/howaunn93/test-linghowaun.git

  cd project-directory

  composer install

  npm install

  php artisan migrate


## USAGE

  Run the following commands in different terminal:

    php artisan serve --port=8000

    npm run dev

  Once ready, head to http://localhost:8000/

