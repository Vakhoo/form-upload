<?php

namespace App\Providers;

use App\Interfaces\File\FileServiceInterface;
use App\Models\File\File;
use App\Observers\FileObserver;
use App\Services\File\FileService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        Paginator::useBootstrap();
        $this->app->bind(FileServiceInterface::class, FileService::class);
        $this->registerObservers();
    }

    /**
     * @return void
     */
    private function registerObservers(): void
    {
        File::observe(FileObserver::class);
    }
}
