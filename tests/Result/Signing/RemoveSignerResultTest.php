<?php
namespace Dokobit\Gateway\Tests\Result\Signing;

use Dokobit\Gateway\Result\Signing\RemoveSignerResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class RemoveSignerResultTest extends TestCase
{
    private $method;

    public function setUp(): void
    {
        $this->method = new RemoveSignerResult();
    }

    use TestResultFieldsTrait;

    public function expectedFields()
    {
        return [
            ['status'],
        ];
    }
}
