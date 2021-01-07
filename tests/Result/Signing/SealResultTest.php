<?php
namespace Dokobit\Gateway\Tests\Result\Signing;

use Dokobit\Gateway\Result\Signing\SealResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class SealResultTest extends TestCase
{
    private $method;

    public function setUp(): void
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
