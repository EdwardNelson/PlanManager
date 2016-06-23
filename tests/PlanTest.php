<?php

namespace EdwardNelson\PlanManager\Test;

use EdwardNelson\PlanManager\Exceptions\InvalidTrialsDays;
use EdwardNelson\PlanManager\Exceptions\PlanPropertyDoesNotExist;

class PlanTest extends TestCase
{
    private $plan;

    public function setUp()
    {
        parent::setUp();
        $plan = new \EdwardNelson\PlanManager\Plan('key');
        $this->plan = $plan;
    }

    public function test_it_throws_exception_when_property_does_not_exist()
    {
        $this->setExpectedException(PlanPropertyDoesNotExist::class);
        $this->plan->nothing;
    }

    public function test_it_can_set_a_name()
    {
        $this->plan->name('name');
        $this->assertEquals('name', $this->plan->name);
    }

    public function test_it_can_set_cost()
    {
        $this->plan->cost(1000);
        $this->assertEquals(1000, $this->plan->cost);

        $this->plan->cost(1000.49);
        $this->assertEquals(1000, $this->plan->cost);

        $this->plan->cost(1000.51);
        $this->assertEquals(1001, $this->plan->cost);
    }

    public function test_it_can_set_the_billing_cycle()
    {
        $this->plan->yearly();
        $this->assertEquals('yearly', $this->plan->billing_cycle);

        $this->plan->monthly();
        $this->assertEquals('monthly', $this->plan->billing_cycle);
    }

    public function test_it_can_set_trials_days()
    {
        $this->plan->trialDays(10);
        $this->assertEquals(10, $this->plan->trial_days);

        $this->plan->trialDays(0);
        $this->assertEquals(0, $this->plan->trial_days);
    }

    public function test_it_can_set_no_trial()
    {
        $this->plan->noTrial();
        $this->assertEquals(0, $this->plan->trial_days);
    }

    public function test_it_only_accepts_integers_for_trial_days()
    {
        $this->setExpectedException(InvalidTrialsDays::class);

        $this->plan->trialDays('test');
    }

    public function test_it_can_be_hidden()
    {
        $this->assertEquals(false, $this->plan->hidden);

        $this->plan->hidden();
        $this->assertEquals(true, $this->plan->hidden);
    }

    public function test_the_methods_can_be_chained()
    {
        $this->plan->hidden()
                ->trialDays(30)
                ->yearly()
                ->cost(3000)
                ->name('My plan');

        $this->assertTrue($this->plan->hidden);
        $this->assertEquals(30, $this->plan->trial_days);
        $this->assertEquals('yearly', $this->plan->billing_cycle);
        $this->assertEquals(3000, $this->plan->cost);
        $this->assertEquals('My plan', $this->plan->name);
    }

    public function test_it_registers_with_the_plan_manager()
    {
        $manager = $this->app->make(\EdwardNelson\PlanManager\Manager::class);
        $plan = $manager->define('plan');

        $this->assertCount(1, $manager->getPlans());
        $this->assertNotNull($manager->find($plan->getKey()));
    }
}
