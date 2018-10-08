<?php

namespace Tests\Unit\Weather\Configurations;

use DarkSky\Configurations\DarkSkyApiConfiguration;
use Tests\TestCase;

class DarkSkyApiConfigurationTest extends TestCase
{
    /**
     * @var string
     */
    private $validApiEndpoint = 'https://api.darksky.net/forecast/b95b5555fb5f8e94cf499f4036618e55/';

    /**
     * @var string
     */
    private $units = 'si';

    /**
     * @var array
     */
    private $excludedBlocks = ['daily', 'currently'];

    /**
     * @var DarkSkyApiConfiguration
     */
    private $SUT;


    public function test_that_the_get_api_endpoint_method_returns_the_endpoint_url()
    {
        $this->SUT = new DarkSkyApiConfiguration($this->excludedBlocks, $this->validApiEndpoint, $this->units);

        $this->assertEquals($this->validApiEndpoint, $this->SUT->getApiEndpoint());
    }

    public function test_that_the_get_excluded_blocks_method_returns_the_endpoint_url()
    {
        $this->SUT = new DarkSkyApiConfiguration($this->excludedBlocks, $this->validApiEndpoint, $this->units);

        $this->assertEquals($this->excludedBlocks, $this->SUT->getExcludedBlocks());
    }

    public function test_that_the_get_units_method_returns_the_endpoint_url()
    {
        $this->SUT = new DarkSkyApiConfiguration($this->excludedBlocks, $this->validApiEndpoint, $this->units);

        $this->assertEquals($this->units, $this->SUT->getUnits());
    }
}
