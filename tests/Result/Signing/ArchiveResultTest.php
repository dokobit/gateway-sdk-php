<?php
namespace Isign\Gateway\Tests\Result\Signing;

use Isign\Gateway\Result\Signing\ArchiveResult;
use Isign\Gateway\Tests\TestCase;
use Isign\Gateway\Tests\Result\TestResultFieldsTrait;

class ArchiveResultTest extends TestCase
{
    private $method;

    public function setUp()
    {
        $this->method = new ArchiveResult();
    }

    use TestResultFieldsTrait;

    public function expectedFields()
    {
        return [
            ['status'],
        ];
    }
}
