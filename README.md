# Dark Sky PHP

This is a PHP wrapper for the official Dark Sky API found at [https://darksky.net/dev/docs](https://darksky.net/dev/docs)

## Getting Started

These instructions will guide you on how to install and use this package to get weather information using the Dark Sky API.

### Prerequisites

This package works with PHP 7. So your php version must be greater `7.0` or later.

### Installing

This package can be installed easily using composer.

```
composer install ndolestudio/darksky-php
```

## Example

Create a class which implements the `LocationDateTimeInput` interface. This class would be used as an input in the `DarkSkyApiClient`

```php
class Request implements \DarkSky\Contracts\LocationDateTimeInput
{
    public function getLatitude(): float
    {
        return 33.22;
    }

    public function getLongitude(): float
    {
        return 24.44;
    }

    public function getDateTime(): DateTime
    {
        return new DateTime('now');
    }
}
```

Use the `LocationDateTimeInput` class created above to fetch the weather data using the `DarkSkyApiClient`

```php
// Require composer dependencies.
require './vendor/autoload.php';

// Here, we create a DarkSkyApiConfiguration
$apiConfiguration = new \DarkSky\Configurations\DarkSkyApiConfiguration(
    ['daily','currently'], // Excluded blocks
    'https://api.darksky.net/forecast/b95b5555fb5f8e94cf499f4036618e55/', // Api Endpoint
    'si' // Units
);

// Use the configuration to create a DarkSkyApiClient
$darkSkyApiClient = new \DarkSky\Clients\DarkSkyApiClient($apiConfiguration, new \GuzzleHttp\Client());

// Create an instance of the LocationDateTimeInput
$request = new Request();

// This fetches the json response
$jsonResponse = $darkSkyApiClient->fetchWeatherData($request);
```

## Running the tests

The tests can be run using `PHPUnit`. The steps to run the tests are listed below


After cloning this repository, download dependencies with composer

```
composer install
```

The step above will install `PHPUnit` which you can run using the command below

```
./vendor/bin/phpunit
```

## Built With

* [Guzzle](http://www.dropwizard.io/1.0.2/docs/) - The extensible PHP HTTP client

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **[AchoArnold](https://github.com/AchoArnold)**

See also the list of [contributors](https://github.com/NdoleStudio/darksky-php/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
