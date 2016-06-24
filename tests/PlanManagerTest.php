<?php

namespace EdwardNelson\PlanManager\Test;

class PlanManagerTest extends TestCase
{
    private $manager;

    public function setUp()
    {
        parent::setUp();
        $manager = app(\EdwardNelson\PlanManager\Manager::class);
        $this->manager = $manager;
    }

    public function test_it_can_define_method_returns_new_plan_instance()
    {
        $this->assertInstanceOf(\EdwardNelson\PlanManager\Plan::class, $this->manager->define('name'));
    }

    public function test_it_defines_the_plan_key_via_define_method()
    {
        $this->assertEquals('newplan', $this->manager->define('newplan')->getKey());
    }

    public function test_it_registers_a_plan_with_the_manager()
    {
        $this->assertCount(0, $this->manager->getPlans());

        $this->manager->define('newplan1');

        $this->assertCount(1, $this->manager->getPlans());
    }

    public function test_properties_are_applied_to_registered_plan()
    {
        $this->manager->define('testplan')
            ->hidden()
            ->trialDays(30)
            ->yearly()
            ->cost(3000)
            ->name('My plan');

        $plan = $this->manager->find('testplan');
        $this->assertTrue($plan->hidden);
        $this->assertEquals(30, $plan->trial_days);
        $this->assertEquals('yearly', $plan->billing_cycle);
        $this->assertEquals(3000, $plan->cost);
        $this->assertEquals('My plan', $plan->name);
    }

    public function test_it_can_remove_a_plan()
    {
        $plan1 = new \EdwardNelson\PlanManager\Plan('test-name1');
        $plan2 = new \EdwardNelson\PlanManager\Plan('test-name2');
        $this->manager->addPlan($plan1);
        $this->manager->addPlan($plan2);

        $this->assertCount(2, $this->manager->getPlans());
        $this->manager->removePlan($plan1);
        $this->assertCount(1, $this->manager->getPlans());
        $this->manager->removePlan($plan2);
    }

    public function test_it_can_return_plans_as_a_collection()
    {
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $this->manager->getPlans());
    }

    public function test_it_can_return_all_plans()
    {
        $plan1 = new \EdwardNelson\PlanManager\Plan('test-name1');
        $plan2 = new \EdwardNelson\PlanManager\Plan('test-name2');
        $this->manager->addPlan($plan1);
        $this->manager->addPlan($plan2);

        $this->assertCount(2, $this->manager->getPlans());
    }

    public function test_it_can_add_a_plan()
    {
        $plan1 = new \EdwardNelson\PlanManager\Plan('test-name1');
        $plan2 = new \EdwardNelson\PlanManager\Plan('test-name2');
        $this->manager->addPlan($plan1);

        $this->assertCount(1, $this->manager->getPlans());
        $this->assertNotFalse(array_search($plan1, $this->manager->getPlans()->toArray()));

        $this->manager->removePlan($plan1);
        $this->assertCount(0, $this->manager->getPlans());
        $this->manager->addPlan($plan1);
        $this->manager->addPlan($plan2);

        $this->assertCount(2, $this->manager->getPlans());
        $this->assertNotFalse(array_search($plan1, $this->manager->getPlans()->toArray()));
        $this->assertNotFalse(array_search($plan2, $this->manager->getPlans()->toArray()));
    }

    public function test_it_can_retrieve_a_plan_by_key()
    {
        $plan1 = new \EdwardNelson\PlanManager\Plan('1');
        $plan2 = new \EdwardNelson\PlanManager\Plan('2');
        $this->manager->addPlan($plan1);
        $this->manager->addPlan($plan2);

        $this->assertEquals($plan1, $this->manager->find('1'));
        $this->assertEquals($plan2, $this->manager->find('2'));
    }

    public function test_registered_plan_key_is_unique()
    {
        $this->setExpectedException(\EdwardNelson\PlanManager\Exceptions\PlanKeyMustBeUnique::class);

        $plan1 = new \EdwardNelson\PlanManager\Plan('test-name1');
        $plan2 = new \EdwardNelson\PlanManager\Plan('test-name1');
        $this->manager->addPlan($plan1);
        $this->manager->addPlan($plan2);
    }
}
