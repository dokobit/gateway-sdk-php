<?php
namespace Dokobit\Gateway\Tests\Query\Signing;

use Dokobit\Gateway\Query\Signing\Prepare;
use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Tests\TestCase;

class PrepareTest extends TestCase
{
    const TOKEN = 'UploadedFileToken';
    const SIGNER_ID = 'MySignerId';
    const CERTIFICATE = 'base64 encoded certificate text';

    /** @var Prepare */
    private $query;

    protected function setUp(): void
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
        $this->assertInstanceOf('Dokobit\Gateway\Result\Signing\PrepareResult', $this->query->createResult());
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
