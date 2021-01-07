<?php
namespace Dokobit\Gateway\Tests\Result\Signing;

use Dokobit\Gateway\Result\Signing\ArchiveResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class ArchiveResultTest extends TestCase
{
    private $method;

    public function setUp(): void
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
