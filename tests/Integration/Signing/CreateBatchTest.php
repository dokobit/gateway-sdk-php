<?php
namespace Dokobit\Gateway\Tests\Integration\Signing;

use Dokobit\Gateway\Query\Signing\CreateBatch;
use Dokobit\Gateway\Result\Signing\CreateBatchResult;
use Dokobit\Gateway\Tests\Integration\TestCase;

class CreateBatchTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->createSigning();
    }

    public function testSuccess()
    {
        /** @var CreateBatchResult $result */
        $result = $this->client->get(new CreateBatch(
            [
                [
                    'token' => $this->signingToken,
                    'signer_token' => $this->signerToken,
                ],
            ]
        ));

        $this->assertSame('ok', $result->getStatus());
        $this->assertNotEmpty($result->getToken());
    }
}
