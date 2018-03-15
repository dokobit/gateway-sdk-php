<?php
namespace Isign\Gateway\Tests;

use Isign\Gateway\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var Isign\Gateway\Query\QueryInterface */
    private $methodStub;

    /** @var Isign\Gateway\Http\ClientInterface */
    private $clientStub;

    /** @var Isign\Gateway\ResponseMapperInterface */
    private $responseMapperStub;

    /** @var Symfony\Component\Validator\Validator */
    private $validatorStub;

    /** @var Client */
    private $client;

    public function setUp()
    {
        $this->methodStub = $this->getMockBuilder('Isign\Gateway\Query\QueryInterface')
            ->setMethods(['getAction', 'getMethod', 'getFields', 'createResult', 'getValidationConstraints'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->methodStub->method('getAction')
            ->willReturn('login');
        $this->methodStub->method('getMethod')
            ->willReturn('post');
        $this->methodStub->method('getFields')
            ->willReturn(['phone' => '+3706xxxxxxx', 'code' => 'xxxxxxxxxxx'])
        ;


        $this->clientStub = $this->getMockBuilder('Isign\Gateway\Http\ClientInterface')
            ->setMethods(['sendRequest'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->responseMapperStub = $this->getMockBuilder('Isign\Gateway\ResponseMapperInterface')
            ->setMethods(['map'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->validatorStub = $this->getMockBuilder('Symfony\Component\Validator\Validator\RecursiveValidator')
            ->disableOriginalConstructor()
            // ->setMethods(['validateValue'])
            ->getMock();

        $this->client = new Client(
            $this->clientStub,
            $this->responseMapperStub,
            $this->validatorStub,
            ['apiKey' => 'xxx', 'sandbox' => true]
        );
    }

    public function testFactoryCreate()
    {
        $client = Client::create(['sandbox' => true, 'apiKey' => 'xxx']);
        $this->assertInstanceOf('Isign\Gateway\Client', $client);
        $this->assertTrue($client->isSandbox());
    }

    public function testFactoryCreateWithLogger()
    {
        $logger = $this->getMockBuilder('Psr\Log\LoggerInterface')
            ->getMock()
        ;
        $client = Client::create(
            ['sandbox' => true, 'apiKey' => 'xxx'],
            $logger
        );
        $this->assertInstanceOf('Isign\Gateway\Client', $client);
    }

    public function testDefaultClientConfiguration()
    {
        $client = new Client(
            $this->clientStub,
            $this->responseMapperStub,
            $this->validatorStub,
            ['apiKey' => 'xxx']
        );

        $this->assertSame(false, $client->isSandbox());
        $this->assertSame('https://gateway.isign.io', $client->getUrl());
        $this->assertSame('https://gateway-sandbox.isign.io', $client->getSandboxUrl());
    }

    public function testCustomClientConfiguration()
    {
        $client = new Client(
            $this->clientStub,
            $this->responseMapperStub,
            $this->validatorStub,
            [
                'sandbox' => true,
                'apiKey' => 'l33t',
                'url' => 'https://custom-api.isign.io',
                'sandboxUrl' => 'https://custom-sandbox.isign.io',
            ]
        );
        $this->assertSame(true, $client->isSandbox());
        $this->assertSame('l33t', $client->getApiKey());
        $this->assertSame('https://custom-api.isign.io', $client->getUrl());
        $this->assertSame('https://custom-sandbox.isign.io', $client->getSandboxUrl());
    }

    /**
     * @expectedException Isign\Gateway\Exception\InvalidApiKey
     */
    public function testApiKeyRequired()
    {
        $client = new Client(
            $this->clientStub,
            $this->responseMapperStub,
            $this->validatorStub
        );
    }

    public function testGetFullMethodUrlForProduction()
    {
        $client = new Client(
            $this->clientStub,
            $this->responseMapperStub,
            $this->validatorStub,
            ['apiKey' => 'xxxxxx']
        );
        $this->assertEquals(
            'https://gateway.isign.io/api/archive.json',
            $client->getFullMethodUrl('archive')
        );
    }

    public function testGetFullMethodUrlForSandbox()
    {
        $this->assertEquals(
            'https://gateway-sandbox.isign.io/api/archive.json',
            $this->client->getFullMethodUrl('archive')
        );
    }

    public function testGet()
    {
        $this->methodStub
            ->expects($this->once())
            ->method('createResult')
            ->willReturn(
                $this->getMockBuilder('Isign\Gateway\Result\ResultInterface')
                    ->disableOriginalConstructor()
                    ->getMock()
            )
        ;
        $this->methodStub
            ->expects($this->once())
            ->method('getMethod')
        ;
        $this->methodStub
            ->expects($this->once())
            ->method('getAction')
        ;
        $this->methodStub
            ->expects($this->once())
            ->method('getValidationConstraints')
        ;

        $this->responseMapperStub
            ->expects($this->once())
            ->method('map')
        ;

        $this->clientStub
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn([])
        ;

        $this->validatorStub
            ->expects($this->once())
            ->method('validate')
            ->willReturn([])
        ;

        $this->client->get($this->methodStub);
    }

    /**
     * @expectedException Isign\Gateway\Exception\QueryValidator
     * @expectedExceptionMessage Query parameters validation failed
     */
    public function testGetValidationFailed()
    {
        $violations = $this->getMockBuilder('Symfony\Component\Validator\ConstraintViolationList')
            ->disableOriginalConstructor()
            ->getMock();
        $violations
            ->method('count')
            ->willReturn(1)
        ;

        $this->validatorStub
            ->expects($this->once())
            ->method('validate')
            ->willReturn($violations)
        ;

        $this->client->get($this->methodStub);
    }
}
