## Overview

A small REST API app for adding movies to a watchlist. Authentication and authorization implemented.
Adding is enabled via the imdb_id parameter and movie details are added externally from the link http://www.omdbapi.com/

## Technologies

- PHP 8.3
- Laravel 13
- Laravel Sanctum for API authentication
- MySQL (or other supported relational database)
- OMDb API for movie metadata lookup
- Vite + Tailwind CSS for frontend asset building
- Laravel Sail for containerized development

## Features

- User registration, login, and Sanctum-protected API routes
- Add movies to watchlist by `imdb_id` with automatic OMDb data import
- List, view, update, and delete watchlist entries
- Ownership-based authorization for watchlist update/delete via policy
- Paginated watchlist results with search and status filters
- Seed IMDb Top 25 watchlist entries for a user via Artisan command

## Authentication and authorization

For authentication, Laravel Sanctuary is used due to the simplicity of the project itself, implementing endpoints for registration, login, and logout.

A policy is used to restrict access to deleting and editing data in the watchlist.

### Why Laravel Sanctum?

Sanctum is the appropriate auth approach for this Laravel API because it is lightweight, built into Laravel, and supports token-based authentication without the extra complexity of Passport or a fully custom JWT solution.

## Installation

Due to the external API, you need to add a link and API key to .env (required).

```
OMDB_BASE_URI=http://www.omdbapi.com/
OMDB_API_KEY=
```

If necessary, set the ports for the DB and URL in .env as well.

### Docker and Sail

1. Clone or download the repository
2. Go to the project directory and run `composer install`
3. Copy `.env.example` to `.env`: `cp .env.example .env`
4. Update database credentials and other environment settings in `.env`
5. Start Sail: `sail up -d`
6. Run database migrations and seeders: `sail artisan migrate --seed`
7. Generate application key: `sail artisan key:generate`
8. Create storage symlink: `sail artisan storage:link`
9. Install frontend dependencies: `sail npm install`
10. Start Vite: `sail npm run dev`
11. Open the app in your browser at `http://localhost:8080`

### Local development without Sail

1. Install PHP, Composer, Node.js, and npm on your machine
2. Run `composer install`
3. Run `npm install`
4. Copy `.env.example` to `.env` and configure database settings
5. Run `php artisan key:generate`
6. Run `php artisan migrate --seed`
7. Run `php artisan storage:link`
8. Start the app: `php artisan serve`
9. Start Vite: `npm run dev`

## Seed IMDb Top 25 Watchlist

For development and testing purposes, you can populate a user's watchlist with the IMDb Top 25 movies.
This command adds the IMDb Top 25 movies to the specified user's watchlist.

Run the following command:

```bash
php artisan watchlist:seed-top {userId}
```

Example:

```bash
php artisan watchlist:seed-top 1
```

If no `userId` is provided, the command uses user ID `1` by default.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
