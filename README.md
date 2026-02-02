<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Blog API (Laravel)

A RESTful API for managing users and posts, built with **Laravel 12** and secured with **Laravel Sanctum**.

## Stack

- Laravel 12, PHP 8.5
- SQLite (local development)
- Laravel Sanctum (token-based auth)

## Features

- **Authentication**: Register, login, logout; `GET /v1/user` returns the current authenticated user.
- **Users**: Protected endpoints for listing, viewing, updating, and deleting users.
    - Authorization via `UserPolicy`: owners can view/update/delete their own record; admins can list all users.
- **Posts**:
    - Public `GET /v1/posts` list.
    - Protected create/update/delete (behind `auth:sanctum`).
- **Resources**: `UserResource` and `PostResource` to shape responses. `PostResource` includes `author` when the relation is eager-loaded.
- **Rate limiting**: `throttle:10,1` (10 requests/minute) on `login` and `register`.
- **Versioning**: All endpoints are namespaced under `/v1` to allow backwards-compatible changes.

## API Endpoints

Base path: `/api/v1`

- `POST /register` — Create account (rate limited).
- `POST /login` — Issue token (rate limited).
- `POST /logout` — Revoke current token (auth required).
- `GET /user` — Current authenticated user (auth required).
- `GET /posts` — List posts (public).
- `POST /posts` — Create post (auth required).
- `PATCH /posts/{post}` — Update post (auth required).
- `DELETE /posts/{post}` — Delete post (auth required).
- `GET /users` — List users (auth required, admin by policy).
- `GET /users/{user}` — Show user (auth required; owner/admin).
- `PATCH /users/{user}` — Update user (auth required; owner/admin).
- `DELETE /users/{user}` — Delete user (auth required; owner/admin).

- `DELETE /users/{user}` — Delete user (auth required; owner/admin).

## Versioning

This API uses path-based versioning. All routes are grouped under the `/v1` prefix (see [routes/api.php](routes/api.php)), e.g. `GET /api/v1/posts`. Future changes can be introduced under `/v2` without breaking existing clients.

## Installation

### 1) Clone

```bash
git clone https://github.com/Guettaf-Mazigh/Blog-api.git
cd Blog-api
```

### 2) Dependencies

```bash
composer install
```

### 3) Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4) Database (SQLite)

```bash
type NUL > database\database.sqlite
php artisan migrate
```

### 5) Run

```bash
php artisan serve
```

## Notes

- Ensure you eager-load the post author when needed, e.g. `Post::with('author')->paginate(10)`, so `author` appears in `PostResource`.
- Login and register are rate-limited; exceeding the limit returns `429 Too Many Requests` temporarily.
