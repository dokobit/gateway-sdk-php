<?php
namespace Isign\Gateway\Tests\Integration\File;

use Isign\Gateway\Query\File\Archive;
use Isign\Gateway\Result\File\ArchiveResult;
use Isign\Gateway\Tests\Integration\TestCase;

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
