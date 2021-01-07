<?php
namespace Dokobit\Gateway\Tests\Result\File;

use Dokobit\Gateway\Result\File\UploadStatusResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class UploadStatusResultTest extends TestCase
{
    private $method;

    public function setUp(): void
    {
        $this->method = new UploadStatusResult();
    }

    use TestResultFieldsTrait;

    public function expectedFields()
    {
        return [
            ['status'],
        ];
    }
}
