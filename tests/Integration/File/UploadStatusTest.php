<?php
namespace Isign\Gateway\Tests\Integration\File;

use Isign\Gateway\Query\File\UploadStatus;
use Isign\Gateway\Result\File\UploadStatusResult;
use Isign\Gateway\Tests\Integration\TestCase;

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
