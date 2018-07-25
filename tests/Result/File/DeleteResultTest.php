<?php
namespace Dokobit\Gateway\Tests\Result\File;

use Dokobit\Gateway\Result\File\DeleteResult;
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
