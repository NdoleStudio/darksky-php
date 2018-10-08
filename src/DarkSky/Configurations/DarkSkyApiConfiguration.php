<?php

namespace DarkSky\Configurations;

class DarkSkyApiConfiguration
{
    /**
     * @var array
     */
    private $excludedBlocks;

    /**
     * @var string
     */
    private $apiEndpoint;

    /**
     * @var string
     */
    private $units;

    /**
     * TODO: Add additional validations to make sure that thee API configuration parameters are valid.
     *
     * @param array  $excludedBlocks
     * @param string $apiEndpoint
     * @param string $units
     */
    public function __construct(array $excludedBlocks, string $apiEndpoint, string $units)
    {
        $this->excludedBlocks = $excludedBlocks;
        $this->apiEndpoint    = $apiEndpoint;
        $this->units          = $units;
    }

    /**
     * @return string
     */
    public function getApiEndpoint(): string
    {
        return $this->apiEndpoint;
    }

    /**
     * @return array
     */
    public function getExcludedBlocks(): array
    {
        return $this->excludedBlocks;
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return $this->units;
    }
}
