<?php
namespace Dokobit\Gateway\Tests\Result\File;

use Dokobit\Gateway\Result\File\CheckResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class CheckResultTest extends TestCase
{
    private $method;

    public function setUp()
    {
        $this->method = new CheckResult();
    }

    use TestResultFieldsTrait;

    public function expectedFields()
    {
        return [
            ['status'],
            ['structure', ['foo' => 'bar']],
        ];
    }
}
