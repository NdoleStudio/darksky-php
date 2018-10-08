<?php

namespace Tests\DarkSky\Traits;

trait DarkSkyApiInteractionTrait
{
    /**
     * @return string
     */
    protected function getDummyApiResponse(): string
    {
        return file_get_contents(
            __DIR__
            . DIRECTORY_SEPARATOR
            . '..'
            . DIRECTORY_SEPARATOR
            . 'data'
            . DIRECTORY_SEPARATOR
            . 'darksky-api-data.json'
        );
    }
}
