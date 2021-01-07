<?php
namespace Dokobit\Gateway\Tests\Query\Signing;

use Dokobit\Gateway\Query\Signing\AddSigner;
use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Tests\TestCase;

class AddSignerTest extends TestCase
{
    const TOKEN = 'UploadedFileToken';
    const SIGNER_ID = 'RandomNotReally';
    const SIGNER_NAME = 'Kraft';
    const SIGNER_SURNAME = 'Lawrence';
    const SIGNER_CODE = '51001091072';
    const SIGNER_PHONE = '+37060000007';

    /** @var Archive */
    private $query;

    /** @var Archive */
    private $queryToken;

    public function setUp(): void
    {
        $this->query = new AddSigner(
            self::TOKEN,
            [
                [
                    'id' => self::SIGNER_ID,
                    'name' => self::SIGNER_NAME,
                    'surname' => self::SIGNER_SURNAME,
                    'code' => self::SIGNER_CODE,
                    'phone' => self::SIGNER_PHONE,
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
        $this->assertArrayHasKey('name', $fields['signers'][0]);
        $this->assertArrayHasKey('surname', $fields['signers'][0]);
        $this->assertArrayHasKey('code', $fields['signers'][0]);
        $this->assertArrayHasKey('phone', $fields['signers'][0]);

        $this->assertSame(self::TOKEN, $fields['token']);
        $this->assertSame(self::SIGNER_ID, $fields['signers'][0]['id']);
        $this->assertSame(self::SIGNER_NAME, $fields['signers'][0]['name']);
        $this->assertSame(self::SIGNER_SURNAME, $fields['signers'][0]['surname']);
        $this->assertSame(self::SIGNER_CODE, $fields['signers'][0]['code']);
        $this->assertSame(self::SIGNER_PHONE, $fields['signers'][0]['phone']);
    }

    public function testGetAction()
    {
        $this->assertSame('signing/'.self::TOKEN.'/addsigner', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->query->getMethod());
    }

    public function testCreateResult()
    {
        $this->assertInstanceOf('Dokobit\Gateway\Result\Signing\AddSignerResult', $this->query->createResult());
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
