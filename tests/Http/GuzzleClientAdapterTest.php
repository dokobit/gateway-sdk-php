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
use PHPUnit\Framework\MockObject\MockObject;

use PHPUnit\Framework\TestCase;

class GuzzleClientAdapterTest extends TestCase
{
    /**
     * @var GuzzleClientAdapter
     */
    private $adapter;

    /** @var PHPUnit_Framework_MockObject_MockObject|Client */
    private $client;

    protected function setUp(): void
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

    public function testDataValidationError400()
    {
        $this->expectException(\Dokobit\Gateway\Exception\InvalidData::class);
        $this->expectExceptionCode('400');
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

    public function testInvalidApiKeyError403()
    {
        $this->expectException(\Dokobit\Gateway\Exception\InvalidApiKey::class);
        $this->expectExceptionCode('403');
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

    public function testServerError500()
    {
        $this->expectException(\Dokobit\Gateway\Exception\ServerError::class);
        $this->expectExceptionCode('500');
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

    public function testTimeout504()
    {
        $this->expectException(\Dokobit\Gateway\Exception\Timeout::class);
        $this->expectExceptionCode('504');
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

    public function testUnexpectedResponseStatusCode()
    {
        $this->expectException(\Dokobit\Gateway\Exception\UnexpectedResponse::class);
        $this->expectExceptionCode('101');
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

    public function testUnexpectedError()
    {
        $this->expectException(\Dokobit\Gateway\Exception\UnexpectedError::class);
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
