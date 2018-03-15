<?php
namespace Isign\Gateway\Tests\Integration\File;

use Isign\Gateway\Query\File\Check;
use Isign\Gateway\Result\File\CheckResult;
use Isign\Gateway\Tests\Integration\TestCase;

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
