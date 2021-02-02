<?php
namespace App\Providers;
use App\Repository\interfaces\EloquentRepositoryInterface;
use App\Repository\interfaces\FollowRepositoryInterface;
use App\Repository\interfaces\UserRepositoryInterface;
use App\Repository\Repositories\BaseRepository;
use App\Repository\Repositories\FollowRepository;
use App\Repository\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(FollowRepositoryInterface::class, FollowRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
