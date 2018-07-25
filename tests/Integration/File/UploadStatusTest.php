<?php
namespace Dokobit\Gateway\Tests\Integration\File;

use Dokobit\Gateway\Query\File\UploadStatus;
use Dokobit\Gateway\Result\File\UploadStatusResult;
use Dokobit\Gateway\Tests\Integration\TestCase;

class UploadStatusTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->uploadFile();
    }

    public function testSuccess()
    {
        /** @var UploadStatusResult $result */
        $result = $this->client->get(new UploadStatus(
            $this->fileToken
        ));

        $this->assertSame('uploaded', $result->getStatus());
    }
}
