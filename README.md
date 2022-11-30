![alt text](https://github.com/neppoz/clearprop/blob/master/public/images/ClearProp_textdown.svg)

Aeroclub management software for small realities with only a few power planes. Basic flight school management with different roles (admins, managers, instructors, members) is included.

With ClearProp you can: 

- keep track of your reservations and flight activities
- manage your members with different price lists
- manage income and expenses
- general statistics
- manage assets (aka your airplanes), a sort of minimal CAMO
- remindes and notifications (webapp and email)

## Requirements and deploy
ClearProp is a Laravel application compattible with php8.0 and newer versions. To deploy do the following:

1. Clone the repo on your server
`git clone https://github.com/neppoz/clearprop.git`

2. Install the app
`composer install --no-interaction --prefer-dist --optimize-autoloader`
`php artisan migrate:fresh --seed`

3. Configure your .env file with your server details. Eventually copy the .env.example file
`cp .env.examle .env`
