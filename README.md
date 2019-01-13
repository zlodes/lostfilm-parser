# GETTING STARTED

## Preparation
0. Install PHP version 7.1 or higher
0. Install MySQL 5.6.4l or higher
0. Download composer: [Official Site](https://getcomposer.org/)

## Installation
Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.6/installation#installation)

Clone the repository

    git clone git@github.com:zlodes/lostfilm-parser

Switch to the repo folder

    cd lostfilm-parser

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Configure .env database params (with DB_ prefix)

    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=lostfilm-parser
    DB_USERNAME=homestead
    DB_PASSWORD=secret

Generate a new application key

    php artisan key:generate
    
Run migrations
    
    php artisan migrate
    
Run first parse (this may take a while)

    php artisan lostfilm:crawl-news-page --first-run

Add Cron entry for daily database update
    
    * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1

Start the local development server

    php artisan serve
    
## DEPLOYMENT 

For using application on production read the [Official guide](https://laravel.com/docs/5.6/deployment)
