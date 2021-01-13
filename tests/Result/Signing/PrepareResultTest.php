<?php
namespace Dokobit\Gateway\Tests\Result\Signing;

use Dokobit\Gateway\Result\Signing\PrepareResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class PrepareResultTest extends TestCase
{
    private $method;

    protected function setUp(): void
    {
        $this->method = new PrepareResult();
    }

    use TestResultFieldsTrait;

    public function expectedFields()
    {
        return [
            ['status'],
            ['dtbs'],
            ['dtbs_hash'],
            ['algorithm'],
        ];
    }
}
