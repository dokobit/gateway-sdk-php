<?php
namespace Dokobit\Gateway\Tests\Http;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\BufferStream;
use GuzzleHttp\Psr7\Response;
use Dokobit\Gateway\Http\GuzzleClientAdapter;
use Psr\Log\LoggerAwareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PHPUnit_Framework_MockObject_MockObject;

class GuzzleClientAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GuzzleClientAdapter
     */
    private $adapter;

    /** @var PHPUnit_Framework_MockObject_MockObject|Client */
    private $client;

    public function setUp()
    {
        $this->client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->adapter = new GuzzleClientAdapter($this->client);
    }

    public function testPost()
    {
        $response = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn(new BufferStream())
        ;
        $this->client
            ->expects($this->once())
            ->method('request')
            ->willReturn($response)
        ;

        $this->adapter->requestJson('POST', 'https://gateway-sandbox.dokobit.com');
    }

    /**
     * @expectedException \Dokobit\Gateway\Exception\InvalidData
     * @expectedExceptionCode 400
     */
    public function testDataValidationError400()
    {
        $request = $this->getMockBuilder(RequestInterface::class)->getMock();
        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();

        $response
            ->method('getStatusCode')
            ->willReturn(400)
        ;
        $response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn(new BufferStream())
        ;

        $this->client
            ->method('request')
            ->will(
                $this->throwException(
                    new ClientException(
                        'Error',
                        $request,
                        $response
                    )
                )
            )
        ;

        $this->adapter->requestJson('POST', 'https://gateway-sandbox.dokobit.com');
    }

    /**
     * @expectedException Dokobit\Gateway\Exception\InvalidApiKey
     * @expectedExceptionCode 403
     */
    public function testInvalidApiKeyError403()
    {
        $request = $this->getMockBuilder(RequestInterface::class)->getMock();
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();

        $response
            ->method('getStatusCode')
            ->willReturn(403)
        ;
        $response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn('response body')
        ;

        $this->client
            ->method('request')
            ->will(
                $this->throwException(
                    new ClientException(
                        'Error',
                        $request,
                        $response
                    )
                )
            )
        ;

        $this->adapter->requestJson('POST', 'https://gateway-sandbox.dokobit.com');
    }

    /**
     * @expectedException Dokobit\Gateway\Exception\ServerError
     * @expectedExceptionCode 500
     */
    public function testServerError500()
    {
        $request = $this->getMockBuilder(RequestInterface::class)->getMock();
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();

        $response
            ->method('getStatusCode')
            ->willReturn(500)
        ;
        $response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn('response body')
        ;

        $this->client
            ->method('request')
            ->will(
                $this->throwException(
                    new ClientException(
                        'Error',
                        $request,
                        $response
                    )
                )
            )
        ;

        $this->adapter->requestJson('POST', 'https://gateway-sandbox.dokobit.com');
    }

    /**
     * @expectedException Dokobit\Gateway\Exception\Timeout
     * @expectedExceptionCode 504
     */
    public function testTimeout504()
    {
        $request = $this->getMockBuilder(RequestInterface::class)->getMock();
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();

        $response
            ->method('getStatusCode')
            ->willReturn(504)
        ;
        $response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn('response body')
        ;

        $this->client
            ->method('request')
            ->will(
                $this->throwException(
                    new ClientException(
                        'Error',
                        $request,
                        $response
                    )
                )
            )
        ;

        $this->adapter->requestJson('POST', 'https://gateway-sandbox.dokobit.com');
    }

    /**
     * @expectedException Dokobit\Gateway\Exception\UnexpectedResponse
     * @expectedExceptionCode 101
     */
    public function testUnexpectedResponseStatusCode()
    {
        $request = $this->getMockBuilder(RequestInterface::class)->getMock();
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();

        $response
            ->method('getStatusCode')
            ->willReturn(101)
        ;
        $response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn('response body')
        ;

        $this->client
            ->method('request')
            ->will(
                $this->throwException(
                    new ClientException(
                        'Error',
                        $request,
                        $response
                    )
                )
            )
        ;

        $this->adapter->requestJson('POST', 'https://gateway-sandbox.dokobit.com');
    }

    /**
     * @expectedException Dokobit\Gateway\Exception\UnexpectedError
     */
    public function testUnexpectedError()
    {
        $this->client
            ->method('request')
            ->will(
                $this->throwException(
                    new \Exception()
                )
            )
        ;

        $this->adapter->requestJson('POST', 'https://gateway-sandbox.dokobit.com');
    }
}
