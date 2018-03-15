<?php
namespace Isign\Gateway\Tests\Query\Signing;

use Isign\Gateway\Query\Signing\Prepare;
use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Tests\TestCase;

class PrepareTest extends TestCase
{
    const TOKEN = 'UploadedFileToken';
    const SIGNER_ID = 'MySignerId';
    const CERTIFICATE = 'base64 encoded certificate text';

    /** @var Prepare */
    private $query;

    public function setUp()
    {
        $this->query = new Prepare(
            self::TOKEN,
            self::SIGNER_ID,
            self::CERTIFICATE
        );
    }

    public function testGetFields()
    {
        $fields = $this->query->getFields();

        $this->assertArrayHasKey('token', $fields);
        $this->assertArrayHasKey('signer_id', $fields);
        $this->assertArrayHasKey('certificate', $fields);

        $this->assertSame(self::TOKEN, $fields['token']);
        $this->assertSame(self::SIGNER_ID, $fields['signer_id']);
        $this->assertSame(self::CERTIFICATE, $fields['certificate']);
    }

    public function testGetAction()
    {
        $this->assertSame('signing/'.self::TOKEN.'/prepare', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->query->getMethod());
    }

    public function testPrepareResult()
    {
        $this->assertInstanceOf('Isign\Gateway\Result\Signing\PrepareResult', $this->query->createResult());
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
