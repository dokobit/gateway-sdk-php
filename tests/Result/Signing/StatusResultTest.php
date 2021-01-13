<?php
namespace Dokobit\Gateway\Tests\Result\Signing;

use Dokobit\Gateway\Result\Signing\StatusResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class StatusResultTest extends TestCase
{
    private $method;

    protected function setUp(): void
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
            ['valid_to'],
            ['structure', ['foo' => 'bar']],
        ];
    }
}
