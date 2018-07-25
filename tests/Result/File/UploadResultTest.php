<?php
namespace Dokobit\Gateway\Tests\Result\File;

use Dokobit\Gateway\Result\File\UploadResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class UploadResultTest extends TestCase
{
    private $method;

    public function setUp()
    {
        $this->method = new UploadResult();
    }

    use TestResultFieldsTrait;

    public function expectedFields()
    {
        return [
            ['status'],
            ['token'],
        ];
    }
}
