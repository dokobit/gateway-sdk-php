<?php
namespace Dokobit\Gateway\Tests\Result;

trait TestResultFieldsTrait
{
    /**
     * @dataProvider expectedFields
     */
    public function testGetFields($name)
    {
        $result = $this->method->getFields();

        $this->assertContains($name, $result);
    }

    /**
     * @dataProvider expectedFields
     */
    public function testSettersAndGetters($name, $value = 'foo')
    {
        $this->assertSetterExists($name, $this->method, $value);
        $this->assertGetterExists($name, $this->method, $value);
    }
}
