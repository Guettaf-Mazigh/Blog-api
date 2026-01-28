<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Blog API - Laravel

A RESTful API built with **Laravel 12** for managing users and blog posts. This project is currently under development.
The API uses token-based authentication with **Laravel Sanctum**.

## Technologies & Tools

- **Framework:** Laravel 12 & PHP 8.5
- **Database:** SQLite (TablePlus)
- **Auth:** Laravel Sanctum
- **Environment:** Laravel Herd
- **Testing:** Postman

## Technologies

- Laravel 12
- PHP 8.5
- SQLite
- Laravel Sanctum
- Postman (for API testing)
- Herd Laravel
- TablePlus (for the DB)

## Instalation

### 1. Clone the project

```bash
git clone [https://github.com/Guettaf-Mazigh/Blog-api.git](https://github.com/Guettaf-Mazigh/Blog-api.git)
cd Blog-api
```

### 2. Install dependencies

```bash
composer install
```

### 3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database configuration (SQLite)

```bash
touch database/database.sqlite
php artisan migrate
```

### 5. Lunch teh server

```bash
php artisan serve
```
