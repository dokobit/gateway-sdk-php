<?php
namespace Isign\Gateway\Tests\Result\File;

use Isign\Gateway\Result\File\UploadResult;
use Isign\Gateway\Tests\TestCase;
use Isign\Gateway\Tests\Result\TestResultFieldsTrait;

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
