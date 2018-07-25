<?php
namespace Dokobit\Gateway\Tests;

use Dokobit\Gateway\SigningPurposeProvider;

class SigningPurposeProviderTest extends TestCase
{
    public function testGetAllSigningPurposes()
    {

        $ref = new \ReflectionClass('Dokobit\Gateway\SigningPurposeProvider');
        $this->assertEquals(count($ref->getConstants()), count(SigningPurposeProvider::getAllSigningPurposes()));
    }
}
