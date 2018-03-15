<?php
namespace Isign\Gateway\Tests\Exception;

use Isign\Gateway\Exception\QueryValidator;
use Symfony\Component\Validator\ConstraintViolationList;

class QueryValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testGetResponseData()
    {
        $message = 'Message';
        $violations = $this->getMockBuilder('Symfony\Component\Validator\ConstraintViolationList')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $violations->method('__toString')->willReturn('list of violations');

        $object = new QueryValidator($message, $violations);

        $this->assertEquals($violations, $object->getViolations());
        $this->assertEquals($message . ': list of violations', $object->getMessage());
    }
}
