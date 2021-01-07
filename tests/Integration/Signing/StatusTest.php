<?php
namespace Dokobit\Gateway\Tests\Integration\Signing;

use Dokobit\Gateway\Query\Signing\Status;
use Dokobit\Gateway\Result\Signing\StatusResult;
use Dokobit\Gateway\Tests\Integration\TestCase;

class StatusTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->createSigning();
    }

    public function testSuccess()
    {
        /** @var StatusResult $result */
        $result = $this->client->get(new Status(
            $this->signingToken
        ));

        $this->assertSame('pending', $result->getStatus());
        $signers = $result->getSigners();
        $this->assertNotEmpty($signers);
        $this->assertArrayHasKey(self::SIGNER1_ID, $signers);
        $this->assertSame('pending', $signers[self::SIGNER1_ID]['status']);
    }
}
