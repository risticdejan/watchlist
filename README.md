## Project Requirements

This project implements the following authentication requirements:

### Why Laravel Sanctum?

Sanctum is the appropriate auth approach for this Laravel API because it is lightweight, built into Laravel, and supports token-based authentication without the extra complexity of Passport or a fully custom JWT solution.

In this application, register/login endpoints issue Sanctum tokens via `$user->createToken('auth-token')->plainTextToken`, and protected routes use the `auth:sanctum` middleware to ensure each request is authorized and scoped to the current authenticated user.

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
