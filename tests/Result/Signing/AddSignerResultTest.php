<?php
namespace Dokobit\Gateway\Tests\Result\Signing;

use Dokobit\Gateway\Result\Signing\AddSignerResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class AddSignerResultTest extends TestCase
{
    private $method;

    protected function setUp(): void
    {
        $this->method = new AddSignerResult();
    }

    use TestResultFieldsTrait;

    public function expectedFields()
    {
        return [
            ['status'],
            ['signers', ['foo' => 'bar']],
        ];
    }
}
