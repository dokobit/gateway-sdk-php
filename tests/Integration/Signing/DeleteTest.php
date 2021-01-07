<?php
namespace Dokobit\Gateway\Tests\Integration\Signing;

use Dokobit\Gateway\Query\Signing\Delete;
use Dokobit\Gateway\Result\Signing\DeleteResult;
use Dokobit\Gateway\Tests\Integration\TestCase;

class DeleteTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->createSigning();
    }

    public function testSuccess()
    {
        /** @var DeleteResult $result */
        $result = $this->client->get(new Delete(
            $this->signingToken
        ));

        $this->assertSame('ok', $result->getStatus());
    }
}
