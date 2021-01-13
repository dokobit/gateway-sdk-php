<?php
namespace Dokobit\Gateway\Tests;

use Dokobit\Gateway\ResponseMapper;

use PHPUnit\Framework\TestCase;

class ResponseMapperTest extends TestCase
{
    private $resultMock;

    protected function setUp(): void
    {
        $this->resultMock = $this
            ->getMockBuilder('Dokobit\Gateway\Result\ResultInterface')
            ->setMethods(['getFields', 'setFieldName1', 'setField2', 'setField1'])
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    public function testMap()
    {
        $mapper = new ResponseMapper();

        $this->resultMock->method('getFields')
            ->willReturn([
                'field_name_1',
                'field2',
            ])
        ;
        $this->resultMock
            ->expects($this->once())
            ->method('setFieldName1')
            ->with($this->equalTo('value1'))
        ;
        $this->resultMock
            ->expects($this->once())
            ->method('setField2')
            ->with($this->equalTo('value2'))
        ;

        $result = $mapper->map(
            ['field_name_1' => 'value1', 'field2' => 'value2'],
            $this->resultMock
        );
        $this->assertInstanceOf('Dokobit\Gateway\Result\ResultInterface', $result);
    }

    public function testDoNotMapFieldWhichIsNotPresentInResponse()
    {
        $mapper = new ResponseMapper();

        $this->resultMock->method('getFields')
            ->willReturn([
                'field1',
            ])
        ;
        $this->resultMock
            ->expects($this->exactly(0))
            ->method('setField1')
            ->with($this->equalTo('value1'))
        ;

        $result = $mapper->map(['field2' => 'value2'], $this->resultMock);
    }
}
