![alt text](https://github.com/neppoz/clearprop/blob/master/public/images/ClearProp_textdown.svg)

Aeroclub management / flight school management software

With ClearProp you can: 

- keep track of your reservations and flight activities
- manage your members with different price lists
- different roles and permissions(admins, managers, instructors, members)
- manage income and expenses
- general statistics
- manage assets (aka your airplanes), a sort of minimal CAMO
- remindes and notifications (webapp and email)
- multiple languages supported (ENG and ITA - DE is partially implemented)

## Requirements and deploy
ClearProp is a Laravel application compattible with php8.0 and newer versions. To deploy do the following:

1. Clone the repo on your server

    `git clone https://github.com/neppoz/clearprop.git`

2. Install the app

    `composer install --no-interaction --prefer-dist --optimize-autoloader`

    `php artisan migrate:fresh --seed`

3. Configure your .env file with your server details. Eventually copy the .env.example file

    `cp .env.examle .env`
    
4. Login with default credentials

    User: admin@clearprop.aero
    
    Pass: BoldPilot
    
    
    
## Join the development team!
We are developing ClearProp for free and in our spare time. Your contribution is appreciated and welcome to maintain the project.

Blue skies!
