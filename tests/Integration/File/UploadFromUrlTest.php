<?php
namespace Dokobit\Gateway\Tests\Integration\File;

use Dokobit\Gateway\Query\File\UploadFromUrl;
use Dokobit\Gateway\Result\File\UploadResult;
use Dokobit\Gateway\Tests\Integration\TestCase;

class UploadFromUrlTest extends TestCase
{
    public function testSuccess()
    {
        /** @var UploadResult $result */
        $result = $this->client->get(new UploadFromUrl(
            'https://gateway-sandbox.dokobit.com/Resources/test.pdf',
            'a50edb61f4bbdce166b752dbd3d3c434fb2de1ab'
        ));

        $this->assertSame('ok', $result->getStatus());
        $this->assertNotEmpty($result->getToken());
    }
}
