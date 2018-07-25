<?php
namespace Dokobit\Gateway\Tests\Integration\File;

use Dokobit\Gateway\Query\File\Check;
use Dokobit\Gateway\Result\File\CheckResult;
use Dokobit\Gateway\Tests\Integration\TestCase;

class CheckTest extends TestCase
{
    public function testStatusOk()
    {
        $file = __DIR__.'/../../data/signed.pdf';

        $type = 'pdf';

        /** @var CheckResult $result */
        $result = $this->client->get(
            new Check($type, $file)
        );

        $this->assertSame('ok', $result->getStatus());
        $this->assertNotEmpty($result->getStructure());
    }
}
