<?php
namespace Dokobit\Gateway\Tests\Result\Signing;

use Dokobit\Gateway\Result\Signing\CreateResult;
use Dokobit\Gateway\Tests\TestCase;
use Dokobit\Gateway\Tests\Result\TestResultFieldsTrait;

class CreateResultTest extends TestCase
{
    private $method;

    protected function setUp(): void
    {
        $this->method = new CreateResult();
    }

    use TestResultFieldsTrait;

    public function expectedFields()
    {
        return [
            ['status'],
            ['token'],
            ['signers', ['foo' => 'bar']],
        ];
    }
}
