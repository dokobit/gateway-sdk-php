<?php
namespace Isign\Gateway\Tests\Result\Signing;

use Isign\Gateway\Result\Signing\PrepareResult;
use Isign\Gateway\Tests\TestCase;
use Isign\Gateway\Tests\Result\TestResultFieldsTrait;

class PrepareResultTest extends TestCase
{
    private $method;

    public function setUp()
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
