<?php
namespace Dokobit\Gateway\Tests\Exception;

use Dokobit\Gateway\Exception\QueryValidator;
use Symfony\Component\Validator\ConstraintViolationList;

use PHPUnit\Framework\TestCase;

class QueryValidatorTest extends TestCase
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
