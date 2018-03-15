<?php
namespace Isign\Gateway\Tests\Integration\File;

use Isign\Gateway\Query\File\Upload;
use Isign\Gateway\Result\File\UploadResult;
use Isign\Gateway\Tests\Integration\TestCase;

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
