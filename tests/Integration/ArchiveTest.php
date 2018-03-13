<?php
namespace Isign\Gateway\Tests\Integration;

use Isign\Gateway\Query\File\Archive;
use Isign\Gateway\Result\ResultInterface;

class ArchiveTest extends TestCase
{
    public function testSuccess()
    {
        /** @var resultInterface $statusResult */
        $statusResult = $this->client->get(new Archive(
            'pdf',
            __DIR__ . '/../data/signed.pdf'
        ));

        $this->assertSame(ResultInterface::STATUS_OK, $statusResult->getStatus());
    }
}
