<?php
namespace Dokobit\Gateway\Tests\Result\File;

use Dokobit\Gateway\Result\File\ArchiveResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class ArchiveResultTest extends TestCase
{
    private $method;

    protected function setUp(): void
    {
        $this->method = new ArchiveResult();
    }

    use TestResultFieldsTrait;

    public function expectedFields()
    {
        return [
            ['status'],
            ['file', ['key1' => 'value1']],
            ['structure', ['key2' => 'value2']],
        ];
    }
}
