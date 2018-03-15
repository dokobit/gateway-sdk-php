<?php
namespace Isign\Gateway\Tests\Query\Signing;

use Isign\Gateway\Query\Signing\RemoveSigner;
use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Tests\TestCase;

class RemoveSignerTest extends TestCase
{
    const TOKEN = 'UploadedFileToken';
    const SIGNER_ID = 'RandomNotReally';

    /** @var RemoveSigner */
    private $query;

    /** @var RemoveSigner */
    private $queryToken;

    public function setUp()
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
        $this->assertInstanceOf('Isign\Gateway\Result\Signing\RemoveSignerResult', $this->query->createResult());
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
