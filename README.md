<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Blog API (Laravel)

A RESTful API for managing users and posts, built with **Laravel 12** and secured with **Laravel Sanctum**.

> Status: Under development (WIP). Features may change; not production-ready.

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
    - Authorization via `PostPolicy`:
        - Create: only users with role `author`.
        - Update: `admin` or `author` who owns the post (`user_id`).
        - Delete: `admin` or the owner of the post.
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
- `GET /posts/{post}` — Show a single post (auth required; enforced via middleware).
- `POST /posts` — Create post (auth required).
- `PATCH /posts/{post}` — Update post (auth required).
- `DELETE /posts/{post}` — Delete post (auth required).
- `GET /users` — List users (auth required, admin by policy).
- `GET /users/{user}` — Show user (auth required; owner/admin).
- `PATCH /users/{user}` — Update user (auth required; owner/admin).

## Authorization & Roles

- Policies:
    - `UserPolicy`: owners can view/update/delete their own record; admins can list all users.
    - `PostPolicy`: only `author` can create; `admin` or `author` owner can update/delete.
- Middleware:
    - `auth:sanctum` protects `GET /v1/posts/{post}` (no `view` policy needed unless you add draft/private logic).
- FormRequests:
    - `StorePostRequest::authorize()` uses `can('create', Post::class)`.
    - `UpdatePostRequest::authorize()` uses `can('update', $this->route('post'))`.
- Controller usage:
    - `PostContoller@store()` sets `user_id` from the authenticated user (not from client input).
    - `PostContoller@update()` applies validated partial updates; `PostContoller@destroy()` authorizes and deletes.

## Data Model

- Relationships:
    - `Post` belongs to `User` via `author()` (`user_id` foreign key).
    - `User` has many `Post` via `post()`.
- Resources:
    - `PostResource` includes `author` when the relation is eager-loaded.

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
