# CodingTest--TelenorHealth-

I solve the coding test with Redis cache of Laravel in Linux(Ubuntu).I use postman for get,post and patch request.

## Installation

We need to Install Redis on Ubuntu.The following link (https://tecadmin.net/install-redis-ubuntu/) provides the redis installation process step by step.

## How to use:

   - Clone the repository with git clone 
   - Copy .env.example file to .env and edit database credentials there
   - Replace CACHE_DRIVER=file by CACHE_DRIVER=redis in .env file.
   - Run composer install
   - Run php artisan key:generate
   - Run php artisan seve for starting server.
