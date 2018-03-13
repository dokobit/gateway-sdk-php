<?php
namespace Isign\Gateway\Tests\Integration;

use Isign\Gateway\Query\File\Check;
use Isign\Gateway\Result\ResultInterface;

class CheckTest extends TestCase
{
    public function testStatusOk()
    {
        $file = __DIR__.'/../data/signed.pdf';

        $type = 'pdf';

        /** @var ResultInterface $statusResult */
        $statusResult = $this->client->get(
            new Check($type, $file)
        );

        $this->assertSame(ResultInterface::STATUS_OK, $statusResult->getStatus());
        $this->assertNotEmpty($statusResult->getStructure());
    }
}
