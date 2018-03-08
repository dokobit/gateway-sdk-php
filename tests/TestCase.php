<?php
namespace Isign\Gateway\Tests;

/**
 * Base test case
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Assert if setter exists
     * @param string $property
     * @param object $object
     * @return void
     */
    protected function assertSetterExists($property, $object)
    {
        $setter = 'set' . $this->toMethodName($property);
        $this->assertTrue(
            method_exists($object, $setter),
            sprintf('Method is %s missing', $setter)
        );
        $object->$setter('foo');
    }

    /**
     * Assert if getter exists. Setter assertion should be executed before.
     * @param string $property
     * @param object $object
     * @return void
     */
    protected function assertGetterExists($property, $object)
    {
        $getter = 'get' . $this->toMethodName($property);
        $this->assertTrue(
            method_exists($object, $getter),
            sprintf('Method is %s missing', $getter)
        );
        $this->assertSame('foo', $object->$getter());
    }

    private function toMethodName($value)
    {
        $parts = explode('_', $value);
        $parts = array_map('ucfirst', $parts);

        return implode('', $parts);
    }
}
