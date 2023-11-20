<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Link eXtractor

### Installation

When cloning this repository for the first time, make a copy of the `.env.example` and rename it to `.env`. After that run the following command:
```
make setup
```
This will install all npm and composer packages, as well as running the migrations and seeding the database. This might take a while.
After that, the Laravel welcome page should be shown when clicking on [this](http://localhost:8000) link.
<br>

### Usage
#### Starting the application
When you want to start the application, run the following command:
```
make up
```
<br>

#### Stopping the application
If you want to stop the application (this means that the docker network will go offline, so the ports are usable again for other applications), run:
```
make down
```
<br>

#### Resetting the database
If you want to reset the database so that it is brought back to its original state, run the following command:
```
make db-fresh
```

This will reset all migrations and seed the database again.
