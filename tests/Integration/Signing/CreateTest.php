<?php
namespace Isign\Gateway\Tests\Integration\Signing;

use Isign\Gateway\Query\Signing\Create;
use Isign\Gateway\Result\Signing\CreateResult;
use Isign\Gateway\Tests\Integration\TestCase;

class CreateTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->uploadFile();
    }

    public function testSuccessMinimal()
    {
        /** @var CreateResult $result */
        $result = $this->client->get(new Create(
            'pdf',
            'CreateTest testSuccessMinimal signing',
            [
                [
                    'token' => $this->fileToken,
                ],
            ]
        ));

        $this->assertSame(CreateResult::STATUS_OK, $result->getStatus());
        $this->assertNotEmpty($result->getToken());
    }

    public function testSuccessFull()
    {
        /** @var CreateResult $result */
        $result = $this->client->get(new Create(
            'pdf',
            'CreateTest testSuccessFull signing',
            [
                [
                    'token' => $this->fileToken,
                    'type' => 'main',
                ],
            ],
            [
                [
                    'id' => self::SIGNER1_ID,
                    'name' => 'Kraft',
                    'surname' => 'Lawrence',
                    'signing_purpose' => 'signature',
                ],
                [
                    'id' => self::SIGNER2_ID,
                    'name' => 'Fleur',
                    'surname' => 'Boland',
                    'signing_purpose' => 'signature',
                ],
            ],
            'https://example.org/postback'
        ));

        $this->assertSame('ok', $result->getStatus());
        $this->assertNotEmpty($result->getToken());
        $signers = $result->getSigners();
        $this->assertNotEmpty($signers);
        $this->assertArrayHasKey(self::SIGNER1_ID, $signers);
        $this->assertArrayHasKey(self::SIGNER2_ID, $signers);
        $this->assertNotEmpty($signers[self::SIGNER1_ID]);
        $this->assertNotEmpty($signers[self::SIGNER2_ID]);
    }
}
