<?php
namespace Isign\Gateway\Tests\Result\File;

use Isign\Gateway\Result\File\UploadStatusResult;
use Isign\Gateway\Tests\TestCase;
use Isign\Gateway\Tests\Result\TestResultFieldsTrait;

class UploadStatusResultTest extends TestCase
{
    private $method;

    public function setUp()
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
