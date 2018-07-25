# Dokobit Gateway PHP Client

[![Build Status](https://travis-ci.org/dokobit/gateway-sdk-php.svg?branch=develop)](https://travis-ci.org/dokobit/gateway-sdk-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dokobit/gateway-sdk-php/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/dokobit/gateway-sdk-php/?branch=develop)
[![Code Coverage](https://scrutinizer-ci.com/g/dokobit/gateway-sdk-php/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/dokobit/gateway-sdk-php/?branch=develop)
[![Build Status](https://scrutinizer-ci.com/g/dokobit/gateway-sdk-php/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/dokobit/gateway-sdk-php/build-status/master)

This library makes it easier to integrate [Dokobit Gateway API](https://www.dokobit.com/solutions/gateway-api) in PHP applications by wrapping all of the Gateway API calls and responses in PHP objects.

## How to start?

1. Instantiate the client object:
    ```php
    use Dokobit\Gateway\Client;

    // <...>
    $client = Client::create([
        'apiKey' => 'xxxxxx',
        'sandbox' => true,
    ]);
    ```
    If you want to log requests, just pass a PSR-3 `LoggerInterface` compatible logger (such as a [Monolog](https://github.com/Seldaek/monolog) instance) as the second parameter to the `create()` method, like this:
    ```php
    use Dokobit\Gateway\Client;
    use Monolog\Handler\StreamHandler;
    use Monolog\Logger;

    // <...>
    $log = new Logger('requests');
    $log->pushHandler(new StreamHandler(__DIR__ . '/path/to/info.log', Logger::INFO));

    $client = Client::create([
        'apiKey' => 'xxxxxx',
        'sandbox' => true,
    ], $log);
    ```

2. Use the client instantiated above to make the desired API calls. To do that, instantiate a respective request object and pass it to the client. For example, to upload a file to Gateway:
    ```php
    use Dokobit\Gateway\Query\File\Upload;

    // <...>
    $request = new Upload('/path/to/your/document.pdf');
    $result = $client->get($request);
    echo $result->getStatus(); // Request status
    echo $result->getToken(); // Uploaded file token
    ```
    Should the request fail for any reason, you'll get an Exception which should help you debug the issue.

The request (query) and response (result) classes closely mirror the API calls, which are documented at https://gateway-sandbox.dokobit.com/api/doc.

To make downloading of signed files more convenient, the `Client` class also provides the `downloadFile()` method. To download a signed file, just call this method like this:
```php
$client->downloadFile($signedFileUrl, $downloadedFilePath);
```

Note: this method will append your access token to the URL automatically, so you can pass it the URLs you receive from the Gateway's postbacks in their verbatim form, without any changes. The same method can also be used to download arbitrary files from other locations, if necessary. Should you want to do that, just pass `false` as the third argument to avoid appending the access token, like this:
```php
$client->downloadFile($signedFileUrl, $downloadedFilePath, false);
```

For further code usage examples, please check integration tests under `tests/Integration`.

## Debugging

To dig more into occured error use following methods:

    echo (string) $exception->getMessage()
    echo (string) $exception->getPrevious()->getResponse()
    var_dump( $exception->getResponseData() )

These methods are available on all exception classes except `UnexpectedError` and `QueryValidator`.

## Develop

Whole testsuite including integrational tests

    phpunit

Don't forget to define `SANDBOX_API_KEY` in your phpunit.xml.


Running unit tests only:

    phpunit --testsuite=Unit

Running integrational tests only:

    phpunit --testsuite=Integration

Running single testcase:

    phpunit tests/Integration/CheckTest.php
