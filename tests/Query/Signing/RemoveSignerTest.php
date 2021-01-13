<?php
namespace Dokobit\Gateway\Tests\Query\Signing;

use Dokobit\Gateway\Query\Signing\RemoveSigner;
use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Tests\TestCase;

class RemoveSignerTest extends TestCase
{
    const TOKEN = 'UploadedFileToken';
    const SIGNER_ID = 'RandomNotReally';

    /** @var RemoveSigner */
    private $query;

    protected function setUp(): void
    {
        $this->query = new RemoveSigner(
            self::TOKEN,
            [
                [
                    'id' => self::SIGNER_ID,
                ],
            ]
        );
    }

    public function testGetFields()
    {
        $fields = $this->query->getFields();

        $this->assertArrayHasKey('token', $fields);
        $this->assertArrayHasKey('signers', $fields);

        $this->assertArrayHasKey(0, $fields['signers']);

        $this->assertArrayHasKey('id', $fields['signers'][0]);

        $this->assertSame(self::TOKEN, $fields['token']);
        $this->assertSame(self::SIGNER_ID, $fields['signers'][0]['id']);
    }

    public function testGetAction()
    {
        $this->assertSame('signing/'.self::TOKEN.'/removesigner', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->query->getMethod());
    }

    public function testCreateResult()
    {
        $this->assertInstanceOf('Dokobit\Gateway\Result\Signing\RemoveSignerResult', $this->query->createResult());
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
