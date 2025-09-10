<?php

namespace App\Providers;

use App\Models\Serie;
use App\Models\User;
use App\Policies\SeriePolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Foundation\Application;
//use App\Services\Auth\JwtGuard;
use App\Classes\Extensions\UserProvider\Mongo\MongoUserProvider;
use App\Events\SeriesCreated;
use App\Events\SeriesDeleted;
use App\Listeners\DeleteCoverWhenSeriesIsDeleted;
use App\Listeners\EmailUsersAboutSeriesCreated;
use App\Listeners\LogSeriesCreated;
use App\Services\Auth\HeaderGuard;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;
use App\Services\Auth\TokenGuard;

class AppServiceProvider extends ServiceProvider
{
    protected $listener = [
        SeriesCreated::class => [
            EmailUsersAboutSeriesCreated::class,
            LogSeriesCreated::class
        ],
        SeriesDeleted::class => [
            DeleteCoverWhenSeriesIsDeleted::class
        ]
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /* Gate::define('update-post', function (User $user, Serie $serie) {
            return $user->id === $serie->user_id;
        });

        Gate::define('edit-settings', function (User $user) {
            return $user->isAdmin ? Response::allow() : Response::deny('You must be an administrator.');
        });

        Gate::define('edit-user-settings', function (User $user, Serie $serie) {
            return $user->id === $serie->id
                ? Response::allow()
                : Response::denyWithStatus(404);
        });

        Gate::define('edit-user-settings-02', function (User $user, Serie $serie) {
            return $user->id === $serie->id
                ? Response::allow()
                : Response::denyAsNotFound();
        });

        Gate::before(function (User $user, string $ability) {
            if ($user->id == 1) {
                return true;
            }
        });

        Gate::after(function (User $user, string $ability, bool|null $result, mixed $arguments) {
            if ($user->id == 1) {
                return true;
            }
        });

        Gate::allowIf(fn(User $user) => $user->id == 1);
        Gate::denyIf(fn(User $user) => $user->id == 1);

        Gate::policy(Serie::class, SeriePolicy::class); */

        /*Auth::extend('jwt', function(Application $app, string $name, array $config){
            return new JwtGuard(Auth::createUserProvider($config['provider']));
        });*/

        Auth::provider('mongo', function (Application $app, $config) {
            //return an instance of Illuminate\Contracts\Auth\UserProvider
            return new MongoUserProvider($app->make('mongo.connection'));
        });

        Auth::extend('header_guard', function (Application $app, string $name, array $config) {
            return new HeaderGuard($app['request']);
        });

        Auth::extend('token_guard', function (Application $app, string $name, array $config) {
            return new TokenGuard(
                Auth::createUserProvider($config['provider']),
                $app['request']
            );
        });

        Collection::macro('toUpper', function () {
            return $this->map(function (string $value) {
                return Str::upper($value);
            });
        });
    }
}
