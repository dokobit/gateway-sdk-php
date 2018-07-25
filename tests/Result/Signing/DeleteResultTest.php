<?php
namespace Dokobit\Gateway\Tests\Result\Signing;

use Dokobit\Gateway\Result\Signing\DeleteResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class DeleteResultTest extends TestCase
{
    private $method;

    public function setUp()
    {
        $this->method = new DeleteResult();
    }

    use TestResultFieldsTrait;

    public function expectedFields()
    {
        return [
            ['status'],
        ];
    }
}
