<?php
namespace Isign\Gateway\Tests\Exception;

use Isign\Gateway\Exception\InvalidData;

class RequestTest extends \PHPUnit_Framework_TestCase
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
