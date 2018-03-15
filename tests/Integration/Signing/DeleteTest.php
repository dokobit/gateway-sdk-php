<?php
namespace Isign\Gateway\Tests\Integration\Signing;

use Isign\Gateway\Query\Signing\Delete;
use Isign\Gateway\Result\Signing\DeleteResult;
use Isign\Gateway\Tests\Integration\TestCase;

class DeleteTest extends TestCase
{
    public function setUp()
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
