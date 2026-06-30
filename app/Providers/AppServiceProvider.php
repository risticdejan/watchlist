<?php

namespace App\Providers;

use App\Repositories\Contracts\Movies\ActorRepository;
use App\Repositories\Contracts\Movies\GenreRepository;
use App\Repositories\Contracts\Movies\MovieRepository;
use App\Repositories\Contracts\Movies\WriterRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\WatchlistRepository;
use App\Repositories\EloquentUserRepository;
use App\Repositories\EloquentWatchlistRepository;
use App\Repositories\Movies\EloquentActorRepository;
use App\Repositories\Movies\EloquentGenreRepository;
use App\Repositories\Movies\EloquentMovieRepository;
use App\Repositories\Movies\EloquentWriterRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(MovieRepository::class, EloquentMovieRepository::class);
        $this->app->bind(ActorRepository::class, EloquentActorRepository::class);
        $this->app->bind(GenreRepository::class, EloquentGenreRepository::class);
        $this->app->bind(WriterRepository::class, EloquentWriterRepository::class);
        $this->app->bind(WatchlistRepository::class, EloquentWatchlistRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(shouldBeStrict: true);

        DB::prohibitDestructiveCommands(
            prohibit: config(key: 'app.env') === 'production'
        );
    }
}
