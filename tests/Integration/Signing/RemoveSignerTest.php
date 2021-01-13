<?php
namespace Dokobit\Gateway\Tests\Integration\Signing;

use Dokobit\Gateway\Query\Signing\RemoveSigner;
use Dokobit\Gateway\Result\Signing\RemoveSignerResult;
use Dokobit\Gateway\Tests\Integration\TestCase;

class RemoveSignerTest extends TestCase
{
    protected function setUp(): void
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
