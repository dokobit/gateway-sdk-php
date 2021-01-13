<?php
namespace Dokobit\Gateway\Tests\Integration\File;

use Dokobit\Gateway\Query\File\Delete;
use Dokobit\Gateway\Result\File\DeleteResult;
use Dokobit\Gateway\Tests\Integration\TestCase;

class DeleteTest extends TestCase
{
    protected function setUp(): void
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
