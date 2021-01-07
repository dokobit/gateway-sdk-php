<?php
namespace Dokobit\Gateway\Tests;

use Dokobit\Gateway\Client;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    /** @var Dokobit\Gateway\Query\QueryInterface */
    private $methodStub;

    /** @var Dokobit\Gateway\Http\ClientInterface */
    private $clientStub;

    /** @var Dokobit\Gateway\ResponseMapperInterface */
    private $responseMapperStub;

    /** @var Symfony\Component\Validator\Validator */
    private $validatorStub;

    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $this->methodStub = $this->getMockBuilder('Dokobit\Gateway\Query\QueryInterface')
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


        $this->clientStub = $this->getMockBuilder('Dokobit\Gateway\Http\ClientInterface')
            ->setMethods(['requestJson', 'requestBody', 'sendRequest'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->responseMapperStub = $this->getMockBuilder('Dokobit\Gateway\ResponseMapperInterface')
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
        $this->assertInstanceOf('Dokobit\Gateway\Client', $client);
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
        $this->assertInstanceOf('Dokobit\Gateway\Client', $client);
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
        $this->assertSame('https://gateway.dokobit.com', $client->getUrl());
        $this->assertSame('https://gateway-sandbox.dokobit.com', $client->getSandboxUrl());
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
                'url' => 'https://custom-api.dokobit.com',
                'sandboxUrl' => 'https://custom-sandbox.dokobit.com',
            ]
        );
        $this->assertSame(true, $client->isSandbox());
        $this->assertSame('l33t', $client->getApiKey());
        $this->assertSame('https://custom-api.dokobit.com', $client->getUrl());
        $this->assertSame('https://custom-sandbox.dokobit.com', $client->getSandboxUrl());
    }

    /**
     * @expectedException Dokobit\Gateway\Exception\InvalidApiKey
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
            'https://gateway.dokobit.com/api/archive.json',
            $client->getFullMethodUrl('archive')
        );
    }

    public function testGetFullMethodUrlForSandbox()
    {
        $this->assertEquals(
            'https://gateway-sandbox.dokobit.com/api/archive.json',
            $this->client->getFullMethodUrl('archive')
        );
    }

    public function testGet()
    {
        $this->methodStub
            ->expects($this->once())
            ->method('createResult')
            ->willReturn(
                $this->getMockBuilder('Dokobit\Gateway\Result\ResultInterface')
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
            ->method('requestJson')
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
     * The client has a few methods to generate view URLs. This tests them.
     */
    public function testGetViewUrls()
    {
        $client = Client::create(['sandbox' => true, 'apiKey' => 'xxx']);

        $signingToken = 'MyToken123';
        $accessToken = 'MyAccessToken';
        $this->assertSame(
            'https://gateway-sandbox.dokobit.com/open/'.$signingToken,
            $client->getOpenUrl($signingToken)
        );
        $this->assertSame(
            'https://gateway-sandbox.dokobit.com/signing/'.$signingToken.'?access_token='.$accessToken,
            $client->getSigningUrl($signingToken, $accessToken)
        );
        $this->assertSame(
            'https://gateway-sandbox.dokobit.com/signing/batch/'.$signingToken,
            $client->getBatchSigningUrl($signingToken)
        );
        $this->assertSame(
            'https://gateway-sandbox.dokobit.com/signing/sequence/'.$signingToken,
            $client->getSequenceSigningUrl($signingToken)
        );
    }

    /**
     * @expectedException Dokobit\Gateway\Exception\QueryValidator
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
