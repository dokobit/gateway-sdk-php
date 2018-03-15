<?php
namespace Isign\Gateway\Tests\Query\Signing;

use Isign\Gateway\Query\Signing\Sign;
use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Tests\TestCase;

class SignTest extends TestCase
{
    const TOKEN = 'SigningToken';
    const SIGNER_ID = 'ThisSignerId';
    const SIGNATURE_VALUE = 'MFs8jeKFZCd9zUyHFXvm==';

    /** @var Sign */
    private $query;

    public function setUp()
    {
        $this->query = new Sign(
            self::TOKEN,
            self::SIGNER_ID,
            self::SIGNATURE_VALUE
        );
    }

    public function testGetFields()
    {
        $fields = $this->query->getFields();

        $this->assertArrayHasKey('token', $fields);
        $this->assertArrayHasKey('signer_id', $fields);
        $this->assertArrayHasKey('signature_value', $fields);

        $this->assertSame(self::TOKEN, $fields['token']);
        $this->assertSame(self::SIGNER_ID, $fields['signer_id']);
        $this->assertSame(self::SIGNATURE_VALUE, $fields['signature_value']);
    }

    public function testGetAction()
    {
        $this->assertSame('signing/'.self::TOKEN.'/sign', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->query->getMethod());
    }

    public function testCreateResult()
    {
        $this->assertInstanceOf('Isign\Gateway\Result\Signing\SignResult', $this->query->createResult());
    }

    public function testHasValidationConstraints()
    {
        $collection = $this->query->getValidationConstraints();

        $this->assertInstanceOf(
            'Symfony\Component\Validator\Constraints\Collection',
            $collection
        );
    }
}
