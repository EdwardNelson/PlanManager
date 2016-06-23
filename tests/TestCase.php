<?php
namespace EdwardNelson\PlanManager\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use EdwardNelson\PlanManager\PlanManagerServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            PlanManagerServiceProvider::class,
        ];
    }

}