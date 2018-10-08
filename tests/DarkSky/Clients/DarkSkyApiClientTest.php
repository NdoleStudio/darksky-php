<?php

namespace Tests\DarkSky\Clients;

use DarkSky\Clients\DarkSkyApiClient;
use DarkSky\Configurations\DarkSkyApiConfiguration;
use DarkSky\Contracts\LocationDateTimeInput;
use DateTime;
use GuzzleHttp\Client;
use PHPUnit_Framework_MockObject_MockObject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use stdClass;
use Tests\TestCase;
use Tests\DarkSky\Traits\DarkSkyApiInteractionTrait;

class DarkSkyApiClientTest extends TestCase
{
    use DarkSkyApiInteractionTrait;

    /**
     * @var DarkSkyApiConfiguration|PHPUnit_Framework_MockObject_MockObject
     */
    private $darkSkyApiConfiguration;

    /**
     * @var Client|PHPUnit_Framework_MockObject_MockObject
     */
    private $httpClient;

    /**
     * @var ResponseInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $httpResponse;

    /**
     * @var StreamInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $responseBody;

    /**
     * @var LocationDateTimeInput|PHPUnit_Framework_MockObject_MockObject
     */
    private $locationInput;

    /**
     * @var float
     */
    private $latitude = 37.8267;

    /**
     * @var int
     */
    private $longitude = -122.4233;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var string
     */
    private $apiEndpoint = 'https://api.darksky.net/forecast/b95b5555fb5f8e94cf499f4036618e55/';

    /**
     * @var array
     */
    private $excludedBlocks = ['daily', 'currently'];

    /**
     * @var string
     */
    private $units = 'si';

    /**
     * @var DarkSkyApiClient
     */
    private $SUT;

    protected function setUp()
    {
        parent::setUp();

        $this->dateTime = new DateTime('now');

        $this->darkSkyApiConfiguration = $this->getMockForConcreteClass(DarkSkyApiConfiguration::class);
        $this->darkSkyApiConfiguration
            ->method($this->methodName([$this->darkSkyApiConfiguration, 'getApiEndpoint']))
            ->willReturn($this->apiEndpoint);
        $this->darkSkyApiConfiguration
            ->method($this->methodName([$this->darkSkyApiConfiguration, 'getExcludedBlocks']))
            ->willReturn($this->excludedBlocks);
        $this->darkSkyApiConfiguration
            ->method($this->methodName([$this->darkSkyApiConfiguration, 'getUnits']))
            ->willReturn($this->units);

        $this->responseBody = $this->getMockForConcreteClass(StreamInterface::class);
        $this->responseBody
            ->method($this->methodName([$this->responseBody, 'getContents']))
            ->willReturn($this->getDummyApiResponse());

        $this->httpResponse = $this->getMockForConcreteClass(ResponseInterface::class);
        $this->httpResponse
            ->method($this->methodName([$this->httpResponse, 'getBody']))
            ->willReturn($this->responseBody);

        $this->httpClient = $this->getMockForConcreteClass(Client::class);

        $this->httpClient
            ->expects($this->once())
            ->method('__call')
            ->willReturn($this->httpResponse);

        $this->locationInput = $this->getMockForConcreteClass(LocationDateTimeInput::class);
        $this->locationInput
            ->method($this->methodName([$this->locationInput, 'getLatitude']))
            ->willReturn($this->latitude);
        $this->locationInput
            ->method($this->methodName([$this->locationInput, 'getLongitude']))
            ->willReturn($this->longitude);
        $this->locationInput
            ->method($this->methodName([$this->locationInput, 'getDateTime']))
            ->willReturn($this->dateTime);

        $this->SUT = new DarkSkyApiClient($this->darkSkyApiConfiguration, $this->httpClient);
    }

    public function test_that_the_fetch_weather_data_method_returns_the_correct_json_data()
    {
        $weatherJsonData = $this->SUT->fetchWeatherData($this->locationInput);

        $this->assertInstanceOf(stdClass::class, $weatherJsonData);

        $this->assertJsonStringEqualsJsonString(
            json_encode($weatherJsonData),
            $this->getDummyApiResponse()
        );
    }

    public function test_that_the_correct_api_url_is_called_when_getting_the_weather_data()
    {
        $apiUrl = $this->apiEndpoint
            . implode(',', [$this->latitude, $this->longitude, $this->dateTime->getTimestamp()])
            . '?exclude='
            . implode(',', $this->excludedBlocks)
            . '&units='
            . $this->units;

        $this->httpClient
            ->expects($this->once())
            ->method('__call')
            ->with(
                $this->equalTo('get'),
                $this->equalTo([$apiUrl])
            )
            ->willReturn($this->getDummyApiResponse());

        $this->SUT->fetchWeatherData($this->locationInput);
    }
}
