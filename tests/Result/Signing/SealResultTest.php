<?php
namespace Isign\Gateway\Tests\Result\Signing;

use Isign\Gateway\Result\Signing\SealResult;
use Isign\Gateway\Tests\TestCase;
use Isign\Gateway\Tests\Result\TestResultFieldsTrait;

class SealResultTest extends TestCase
{
    private $method;

    public function setUp()
    {
        $this->method = new SealResult();
    }

    use TestResultFieldsTrait;

    public function expectedFields()
    {
        $this->markTestIncomplete('Result not documented at the moment.');
        return [
            ['status'],
        ];
    }
}
