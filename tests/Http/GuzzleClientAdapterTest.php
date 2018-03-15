<?php
namespace Isign\Gateway\Tests\Http;

use GuzzleHttp\Exception\ClientException;
use Isign\Gateway\Http\GuzzleClientAdapter;
use Psr\Log\LoggerAwareInterface;

class GuzzleClientAdapterTest extends \PHPUnit_Framework_TestCase
{
    private $adapter;
    private $client;

    public function setUp()
    {
        $this->client = $this->getMockBuilder('GuzzleHttp\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $this->client
            ->method('createRequest')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://gateway-sandbox.isign.io'),
                []
            )
            ->willReturn(
                $this->getMockBuilder('GuzzleHttp\Message\Request')
                    ->disableOriginalConstructor()
                    ->getMock()
            );

        $this->adapter = new GuzzleClientAdapter($this->client);
    }

    public function testPost()
    {
        $response = $this->getMockBuilder('GuzzleHttp\Message\Response')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $response
            ->expects($this->once())
            ->method('json')
        ;
        $this->client
            ->expects($this->once())
            ->method('send')
            ->willReturn($response)
        ;
        $this->client
            ->expects($this->once())
            ->method('createRequest')
        ;

        $this->adapter->sendRequest('POST', 'https://gateway-sandbox.isign.io');
    }

    /**
     * @expectedException Isign\Gateway\Exception\InvalidData
     * @expectedExceptionCode 400
     */
    public function testDataValidationError400()
    {
        $request = $this->getMockBuilder('GuzzleHttp\Message\RequestInterface')->getMock();
        $response = $this->getMockBuilder('GuzzleHttp\Message\ResponseInterface')->getMock();

        $response
            ->method('getStatusCode')
            ->willReturn(400)
        ;
        $response
            ->expects($this->once())
            ->method('json')
            ->willReturn([])
        ;

        $this->client
            ->method('send')
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
        $this->client
            ->expects($this->once())
            ->method('createRequest')
        ;

        $this->adapter->sendRequest('POST', 'https://gateway-sandbox.isign.io');
    }

    /**
     * @expectedException Isign\Gateway\Exception\InvalidApiKey
     * @expectedExceptionCode 403
     */
    public function testInvalidApiKeyError403()
    {
        $request = $this->getMockBuilder('GuzzleHttp\Message\RequestInterface')->getMock();
        $response = $this->getMockBuilder('GuzzleHttp\Message\ResponseInterface')->getMock();

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
            ->method('send')
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

        $this->adapter->sendRequest('POST', 'https://gateway-sandbox.isign.io');
    }

    /**
     * @expectedException Isign\Gateway\Exception\ServerError
     * @expectedExceptionCode 500
     */
    public function testServerError500()
    {
        $request = $this->getMockBuilder('GuzzleHttp\Message\RequestInterface')->getMock();
        $response = $this->getMockBuilder('GuzzleHttp\Message\ResponseInterface')->getMock();

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
            ->method('send')
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

        $this->adapter->sendRequest('POST', 'https://gateway-sandbox.isign.io');
    }

    /**
     * @expectedException Isign\Gateway\Exception\Timeout
     * @expectedExceptionCode 504
     */
    public function testTimeout504()
    {
        $request = $this->getMockBuilder('GuzzleHttp\Message\RequestInterface')->getMock();
        $response = $this->getMockBuilder('GuzzleHttp\Message\ResponseInterface')->getMock();

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
            ->method('send')
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

        $this->adapter->sendRequest('POST', 'https://gateway-sandbox.isign.io');
    }

    /**
     * @expectedException Isign\Gateway\Exception\UnexpectedResponse
     * @expectedExceptionCode 101
     */
    public function testUnexpectedResponseStatusCode()
    {
        $request = $this->getMockBuilder('GuzzleHttp\Message\RequestInterface')->getMock();
        $response = $this->getMockBuilder('GuzzleHttp\Message\ResponseInterface')->getMock();

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
            ->method('send')
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

        $this->adapter->sendRequest('POST', 'https://gateway-sandbox.isign.io');
    }

    /**
     * @expectedException Isign\Gateway\Exception\UnexpectedError
     */
    public function testUnexpectedError()
    {
        $request = $this->getMockBuilder('GuzzleHttp\Message\RequestInterface')->getMock();
        $response = $this->getMockBuilder('GuzzleHttp\Message\ResponseInterface')->getMock();

        $this->client
            ->method('send')
            ->will(
                $this->throwException(
                    new \Exception()
                )
            )
        ;

        $this->adapter->sendRequest('POST', 'https://gateway-sandbox.isign.io');
    }
}
