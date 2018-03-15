<?php
namespace Isign\Gateway\Tests\Result\File;

use Isign\Gateway\Result\File\CheckResult;
use Isign\Gateway\Tests\TestCase;
use Isign\Gateway\Tests\Result\TestResultFieldsTrait;

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
