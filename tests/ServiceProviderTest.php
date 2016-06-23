<?php
namespace EdwardNelson\PlanManager\Test;

use Mockery as m;
use Illuminate\Contracts\Foundation\Application;
use EdwardNelson\PlanManager\PlanManagerServiceProvider;

class ServiceProviderTest extends TestCase
{
    /**
     * @var Mockery\Mock
     */
    protected $appMock;

    /**
     * @var PlanManagerServiceProvider
     */
    protected $provider;

    public function setUp()
    {
        $this->setUpMocks();

        $this->provider = new PlanManagerServiceProvider($this->appMock);
        parent::setUp();

    }

    protected function setUpMocks()
    {
        $this->appMock = m::mock(Application::class);
    }

    public function test_it_can_be_constructed()
    {
        $this->assertInstanceOf(PlanManagerServiceProvider::class, $this->provider);
    }


    public function test_it_calls_singleton_in_register_method()
    {
        $this->appMock->shouldReceive('singleton')->once();

        $this->provider->register();
    }

    public function test_it_boots_plans()
    {
        $mock = m::mock('\EdwardNelson\PlanManager\PlanManagerServiceProvider[bootPlans]', [$this->appMock]);
        $mock->shouldReceive('bootPlans')->once();

        $mock->boot();
    }
}