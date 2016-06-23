<?php

namespace EdwardNelson\PlanManager;

use EdwardNelson\PlanManager\Exceptions\PlanKeyMustBeUnique;
use Illuminate\Support\Collection;

class Manager
{
    private $plans = array();

    /**
     * Define a plan.
     *
     * @param string $key Plan name
     *
     * @return \EdwardNelson\PlanManager\Plan
     */
    public function define($key)
    {
        return $this->addPlan(new Plan($key));
    }

    /**
     * Add a plan to the manager.
     *
     * @param \EdwardNelson\PlanManager\Plan $plan
     *
     * @return Plan
     */
    public function addPlan(Plan $plan)
    {
        $this->registerPlan($plan);

        return $plan;
    }

    /**
     * Remove a plan from the manager for the current request.
     *
     * @param string|\EdwardNelson\PlanManager\Plan $plan
     */
    public function removePlan($plan)
    {
        $key = $plan instanceof Plan ? $plan->getKey() : $plan;

        foreach ($this->plans as $array_key => $plan) {
            if ($plan->getKey() === $key) {
                unset($this->plans[$array_key]);
                break;
            }
        }
    }

    /**
     * Find a plan by its key.
     *
     * @param string $key
     *
     * @return \EdwardNelson\PlanManager\Plan|null
     */
    public function find($key)
    {
        $planByKey = null;

        foreach ($this->plans as $plan) {
            if ($plan->getKey() === $key) {
                $planByKey = $plan;
                break;
            }
        }

        return $planByKey;
    }

    /**
     * Return the plans.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPlans()
    {
        return new Collection($this->plans);
    }

    /**
     * Register a plan with the manager.
     *
     * @param Plan $plan
     *
     * @throws PlanKeyMustBeUnique
     */
    private function registerPlan(Plan $plan)
    {
        if ($this->find($plan->getKey())) {
            throw new PlanKeyMustBeUnique(sprintf('The key "%s" is already bound to the manager.', $plan->getKey()));
        }

        array_push($this->plans, $plan);
    }
}
