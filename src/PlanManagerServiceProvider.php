<?php

namespace EdwardNelson\PlanManager;

use Illuminate\Support\ServiceProvider;

class PlanManagerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Manager::class, function () {
            return new Manager();
        });
    }

    public function boot()
    {
        $this->bootPlans();
    }

    public function bootPlans()
    {
        //        PlanManager::define('team-monthly')
//                    ->name('Team monthly')
//                    ->trialDays(10)
//                    ->yearly()
//                    ->cost(3000);
    }
}
