<?php
namespace Isign\Gateway\Tests;

use Isign\Gateway\SigningPurposeProvider;

class SigningPurposeProviderTest extends TestCase
{
    public function testGetAllSigningPurposes()
    {

        $ref = new \ReflectionClass('Isign\Gateway\SigningPurposeProvider');
        $this->assertEquals(count($ref->getConstants()), count(SigningPurposeProvider::getAllSigningPurposes()));
    }
}
