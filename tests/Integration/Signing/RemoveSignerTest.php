<?php
namespace Isign\Gateway\Tests\Integration\Signing;

use Isign\Gateway\Query\Signing\RemoveSigner;
use Isign\Gateway\Result\Signing\RemoveSignerResult;
use Isign\Gateway\Tests\Integration\TestCase;

class RemoveSignerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->createSigning();
    }

    public function testSuccess()
    {
        /** @var RemoveSignerResult $result */
        $result = $this->client->get(new RemoveSigner(
            $this->signingToken,
            [
                [
                    'id' => self::SIGNER1_ID,
                ],
            ]
        ));

        $this->assertSame('ok', $result->getStatus());
    }
}
