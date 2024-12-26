php version used - 8.2.25
composer version - 2.8.2
node.js - 23.5.0

There is some steps to run this project locally

for the api project:

1) composer install
2) composer run dev
3) docker composer up
4) php artisan migrate
5) php artisan db:seed (or alternatively php artisan migrate:refresh --seed)

for the client

1) npm install
2) npm run dev

client UI uses 5175 PORT if it's already taken u can check it in on your system by running command in CMD: netstat -na | find "5175" and terminate it by this command: taskkill /f /pid YOUR_PID_NUMBER

For email testing I used Mailtrap specifically, but u can choose freely any other mailer for testing and put those smtp credentials in .env config file

All necessary configuration written in .txt file except mailer sender or in .env.example file
