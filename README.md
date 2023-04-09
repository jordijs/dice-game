##About

Project of creation a Laravel API to play a dice game. If result of the two dices is 7, the player wins the game. Results and stats are calculated with PHP and stored to MySQL database.
Implementation of authentication via Oauth 2 and Passport. Each API route is protected with a middleware according to the role of the user. Roles are implemented with the Spatie library. If the user is a player, they can watch their own data only. Users with admin role can see all data.
Testing of the routes using PHPUnit.
