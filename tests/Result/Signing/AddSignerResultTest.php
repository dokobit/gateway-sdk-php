<?php
namespace Isign\Gateway\Tests\Result\Signing;

use Isign\Gateway\Result\Signing\AddSignerResult;
use Isign\Gateway\Tests\TestCase;
use Isign\Gateway\Tests\Result\TestResultFieldsTrait;

class AddSignerResultTest extends TestCase
{
    private $method;

    public function setUp()
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
