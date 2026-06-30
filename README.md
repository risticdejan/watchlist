## Project Requirements

This project implements the following authentication requirements:

- Users can register and log in.
- All watchlist endpoints are protected and scoped to the authenticated user.
- Authentication is implemented using Laravel Sanctum for the API.

### Why Laravel Sanctum?

Sanctum is the appropriate auth approach for this Laravel API because it is lightweight, built into Laravel, and supports token-based authentication without the extra complexity of Passport or a fully custom JWT solution.

- It integrates directly with Laravel's authentication guards and middleware.
- It supports issuing personal access tokens for API clients.
- It is simpler to configure and maintain for a single-application API.

In this application, register/login endpoints issue Sanctum tokens via `$user->createToken('auth-token')->plainTextToken`, and protected routes use the `auth:sanctum` middleware to ensure each request is authorized and scoped to the current authenticated user.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
