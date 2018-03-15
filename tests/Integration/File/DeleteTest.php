<?php
namespace Isign\Gateway\Tests\Integration\File;

use Isign\Gateway\Query\File\Delete;
use Isign\Gateway\Result\File\DeleteResult;
use Isign\Gateway\Tests\Integration\TestCase;

class DeleteTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->uploadFile();
    }

    public function testSuccess()
    {
        /** @var DeleteResult $result */
        $result = $this->client->get(new Delete(
            $this->fileToken
        ));

        $this->assertSame('ok', $result->getStatus());
    }
}
