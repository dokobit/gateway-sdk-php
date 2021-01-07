<?php
namespace Dokobit\Gateway\Tests\Result\Signing;

use Dokobit\Gateway\Result\Signing\CreateBatchResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class CreateBatchResultTest extends TestCase
{
    private $method;

    protected function setUp(): void
    {
        $this->method = new CreateBatchResult();
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
