<?php
namespace Isign\Gateway\Tests\Integration\Signing;

use Isign\Gateway\Query\Signing\Status;
use Isign\Gateway\Result\Signing\StatusResult;
use Isign\Gateway\Tests\Integration\TestCase;

class StatusTest extends TestCase
{
    public function setUp()
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
