# ToDo

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/b43dad7922b04431a05dc0bc9a2d6f83)](https://www.codacy.com/gh/EdwigeGC/ToDo/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=EdwigeGC/ToDo&amp;utm_campaign=Badge_Grade)

This project was made to validate my training as a web PHP/Symfony developer.   The fake company ToDo & Co developed its first application with Symphony framework 3.1 a few years ago and didn’t maintain it.
This application allows registered and logged-in users to manage the to-do list of their team.  
My job was to improve it.

## Getting start

### Prerequisites

Installation of To Do List requires:

  * Symfony 4.4
  * PHP version 7.4.12
  * MySQL version 5.7
  * Apache Server 2.4.46
  * Composer 2.0
  * Doctrine/ORM < 2.5
  * Bootstrap 5.0

Dependency used for testing the project:
 * phpunit/phpunit < 9.5 

### Installation

 1. On your local machine, create a local repository and make a  
   `git remote add` to your GitHub repository
 2. Copy the link on GitHub and clone it on your local repository   
   `git clone https://github.com/EdwigeGC/ToDo.git`
 3. Open your terminal and run:   `composer install` to install dependencies
 4. Open file .env and configure username and password for database connection. Example:   
   `DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7`
 5. Create database:  
   `php bin/console doctrine:database:create`  
   `doctrine:schema:create`
 6. Fill the database with fixtures:   
   `php bin/console make:migration`  
   `php bin/console doctrine:migration:migrate`  
   `php bin/console doctrine:fixtures:load`

## Features
Only registered users can access to the application:
  *  Get list of all tasks to do
  *  Get list of all tasks done
  *  Get the details of a task
  *  Edit a task
  *  Mark a task as done
  *  Delete a task (if the user is the author of the task)
  *  Authenticate

The admin can also:
  *  Create a user
  *  Edit a user
  *  Manage unassigned tasks

Run the tests:
In your terminal, run `vendor/bin/phpunit`

## Credit
photos: @SaroOh

## Contribution
If you want to contribute to this project and make it better, your help is very welcome. 
Look [the documentation](https://github.com/EdwigeGC/ToDo/blob/main/public/Contributing.md) to see how contribute.
