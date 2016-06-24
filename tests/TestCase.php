<?php

namespace EdwardNelson\PlanManager\Test;

use EdwardNelson\PlanManager\PlanManagerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

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
