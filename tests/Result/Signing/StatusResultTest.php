<?php
namespace Isign\Gateway\Tests\Result\Signing;

use Isign\Gateway\Result\Signing\StatusResult;
use Isign\Gateway\Tests\TestCase;
use Isign\Gateway\Tests\Result\TestResultFieldsTrait;

class StatusResultTest extends TestCase
{
    private $method;

    public function setUp()
    {
        $this->method = new StatusResult();
    }

    use TestResultFieldsTrait;

    public function expectedFields()
    {
        return [
            ['status'],
            ['signers', ['foo' => 'bar']],
            ['file'],
            ['validTo'],
            ['structure', ['foo' => 'bar']],
        ];
    }
}
