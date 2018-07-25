<?php
namespace Dokobit\Gateway\Tests\Integration\File;

use Dokobit\Gateway\Query\File\Archive;
use Dokobit\Gateway\Result\File\ArchiveResult;
use Dokobit\Gateway\Tests\Integration\TestCase;

class ArchiveTest extends TestCase
{
    public function testSuccess()
    {
        /** @var ArchiveResult $result */
        $result = $this->client->get(new Archive(
            'pdf',
            __DIR__ . '/../../data/signed.pdf'
        ));

        $this->assertSame('ok', $result->getStatus());
    }
}
