<?php

namespace EdwardNelson\PlanManager;

use Illuminate\Support\Facades\Facade;

class PlanManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Manager::class;
    }
}
