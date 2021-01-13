<?php
namespace Dokobit\Gateway\Tests\Exception;

use Dokobit\Gateway\Exception\InvalidData;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testGetResponseData()
    {
        $message = 'Message';
        $code = 404;
        $previous = new \Exception();
        $data = ['key' => 'value'];

        $object = new InvalidData($message, $code, $previous, $data);

        $message .= ' Response: ' . var_export($data, true);
        $this->assertEquals($data, $object->getResponseData());
        $this->assertEquals($message, $object->getMessage());
        $this->assertEquals($code, $object->getCode());
        $this->assertEquals($previous, $object->getPrevious());
    }
}
