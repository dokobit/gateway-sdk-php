<?php
namespace Isign\Gateway\Tests\Result\File;

use Isign\Gateway\Result\File\ArchiveResult;
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
            ['status', 'ok'],
            ['file', ['key1' => 'value1']],
            ['structure', ['key2' => 'value2']],
        ];
    }
}
