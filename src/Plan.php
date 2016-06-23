<?php

namespace EdwardNelson\PlanManager;

use EdwardNelson\PlanManager\Exceptions\BillingCycleNotSupported;
use EdwardNelson\PlanManager\Exceptions\InvalidTrialsDays;
use EdwardNelson\PlanManager\Exceptions\PlanPropertyDoesNotExist;

class Plan
{
    /**
     * The provider key of the plan.
     *
     * @var string
     */
    private $key;

    /**
     * The supported billing cycles.
     */
    private static $cycles = array(
        'yearly',
        'monthly',
    );

    /**
     * The properties of the plan.
     *
     * @var
     */
    private $properties = array(
        'trial_days' => 15,
        'name' => null,
        'billing_cycle' => null,
        'cost' => 0,
        'hidden' => false,
    );

    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Set the display name of the plan.
     *
     * @param string $name
     *
     * @return $this
     */
    public function name($name)
    {
        $this->setProperty('name', $name);

        return $this;
    }

    /**
     * Set price in lowest currency denomination.
     *
     * @param int $price
     *
     * @return $this
     */
    public function cost($price)
    {
        $this->setProperty('cost', round($price));

        return $this;
    }

    /**
     * Set the billing cycle to yearly.
     *
     * @return $this
     */
    public function yearly()
    {
        $this->setBillingCycle('yearly');

        return $this;
    }

    /**
     * Set the plan to hidden.
     *
     * @throws PlanPropertyDoesNotExist
     *
     * @return $this
     */
    public function hidden()
    {
        $this->setProperty('hidden', true);

        return $this;
    }

    /**
     * Set the billing cycle to yearly.
     *
     * @return $this
     */
    public function monthly()
    {
        $this->setBillingCycle('monthly');

        return $this;
    }

    /**
     * Returns the provider key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the number of trial days.
     *
     * @param int $days
     *
     * @throws InvalidTrialsDays
     * @throws PlanPropertyDoesNotExist
     *
     * @return $this
     */
    public function trialDays($days)
    {
        if (!is_int($days)) {
            throw new InvalidTrialsDays(sprintf('The value "%s" is not an integer.', $days));
        }

        $this->setProperty('trial_days', $days);

        return $this;
    }

    /**
     * Set the plan to have no trial.
     *
     * @throws InvalidTrialsDays
     *
     * @return $this
     */
    public function noTrial()
    {
        $this->trialDays(0);

        return $this;
    }

    /**
     * Return properties of the plan.
     *
     * @param string $property
     *
     * @throws PlanPropertyDoesNotExist
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (!$this->propertyExists($property)) {
            throw new PlanPropertyDoesNotExist(sprintf('This plan does not have the property "%s".', $property));
        }

        return $this->properties[$property];
    }

    /**
     * Set properties of the plan.
     *
     * @param string $property
     * @param string $value
     *
     * @throws PlanPropertyDoesNotExist
     */
    private function setProperty($property, $value)
    {
        if (!$this->propertyExists($property)) {
            throw new PlanPropertyDoesNotExist(sprintf('This plan does not have the property "%s".', $property));
        }

        $this->properties[$property] = $value;
    }

    /**
     * Determine if the given property exists.
     *
     * @param string $property
     *
     * @return bool
     */
    private function propertyExists($property)
    {
        return array_key_exists($property, $this->properties);
    }

    /**
     * Set the billing cycle.
     *
     * @param string $cycle
     *
     * @throws BillingCycleNotSupported
     * @throws PlanPropertyDoesNotExist
     */
    private function setBillingCycle($cycle)
    {
        if (!in_array($cycle, static::$cycles)) {
            throw new BillingCycleNotSupported(sprinf('The billing cycle "%s" is not supported', $cycle));
        }

        $this->setProperty('billing_cycle', $cycle);
    }
}
