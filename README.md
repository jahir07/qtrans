<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation
* First simply clone this repo by using following command:
```
git clone https://github.com/jahir07/qtrans.git
```

* Now navigate to the directory you cloned the repo into and run the following command
```
composer install
```

* Publish configuration & views:
```
php artisan vendor:publish
```

* Create .env file
```
mv .env.example .env
```

* Set application key
```
php artisan key:generate
```

* Set your database credentials.

* Migrate the databases:
```
php artisan migrate
```
* Import demo data
```
php artisan db:seed
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
