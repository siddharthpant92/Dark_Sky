# DarkSky-Cognizant

Using the Dark Sky API, changing the color theme of the web page based on the weather conditions of a certain place.

# Tools
- Laravel framework
- Composer
- [Dark Sky API](https://darksky.net/dev/docs)

# Setting up the environment
Download and set up [composer](https://getcomposer.org/download/) on your system.
To check if composer installed successfully open your command line and type 'composer' 

Install [laravel](https://laravel.com/docs/5.5/installation#installing-laravel) using composer 'composer global require "laravel/installer" '
    
To create a new laravel project, navigate to the directory you want to create the project in. In the command line, type 'laravel new <folder-name>'

Assuming php has been installed, you can create and host your own development server locally on your system at http://localhost:8000 by navigating to your project directory and typing the following in your command line: 'php artisan serve'

If the above command doesn't work, try running: 'composer dump-autoload' and 'composer update'