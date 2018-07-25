<?php
namespace Dokobit\Gateway\Tests\Integration\File;

use Dokobit\Gateway\Query\File\Upload;
use Dokobit\Gateway\Result\File\UploadResult;
use Dokobit\Gateway\Tests\Integration\TestCase;

class UploadTest extends TestCase
{
    public function testSuccess()
    {
        /** @var UploadResult $result */
        $result = $this->client->get(new Upload(
            __DIR__ . '/../../data/document.pdf'
        ));

        $this->assertSame('ok', $result->getStatus());
        $this->assertNotEmpty($result->getToken());
    }
}
