<?php
namespace Isign\Gateway\Tests\Result\Signing;

use Isign\Gateway\Result\Signing\CreateResult;
use Isign\Gateway\Tests\TestCase;
use Isign\Gateway\Tests\Result\TestResultFieldsTrait;

class CreateResultTest extends TestCase
{
    private $method;

    public function setUp()
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
