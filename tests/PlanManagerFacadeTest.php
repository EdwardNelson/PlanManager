<?php

namespace EdwardNelson\PlanManager\Test;

use EdwardNelson\PlanManager\Manager;
use EdwardNelson\PlanManager\PlanManager;

class PlanManagerFacadeTest extends TestCase
{

    public function test_it_returns_instance_of_plan_manager()
    {
        $this->assertInstanceOf(Manager::class, PlanManager::getFacadeRoot());
    }

}