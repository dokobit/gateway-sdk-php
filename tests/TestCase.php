<?php
namespace Dokobit\Gateway\Tests;

/**
 * Base test case
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Assert if setter exists
     * @param string $property
     * @param object $object
     * @param mixed $setValue
     * @return void
     */
    protected function assertSetterExists($property, $object, $setValue = 'foo')
    {
        $setter = 'set' . $this->toMethodName($property);
        $this->assertTrue(
            method_exists($object, $setter),
            sprintf('Method is %s missing', $setter)
        );
        $object->$setter($setValue);
    }

    /**
     * Assert if getter exists. Setter assertion should be executed before.
     * @param string $property
     * @param object $object
     * @param mixed $testValue
     * @return void
     */
    protected function assertGetterExists($property, $object, $testValue = 'foo')
    {
        $getter = 'get' . $this->toMethodName($property);
        $this->assertTrue(
            method_exists($object, $getter),
            sprintf('Method is %s missing', $getter)
        );
        $this->assertSame($testValue, $object->$getter());
    }

    private function toMethodName($value)
    {
        $parts = explode('_', $value);
        $parts = array_map('ucfirst', $parts);

        return implode('', $parts);
    }
}
