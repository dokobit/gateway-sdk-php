<?php
namespace Isign\Gateway\Tests\Query\Signing;

use Isign\Gateway\Query\Signing\Create;
use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Tests\TestCase;

class CreateTest extends TestCase
{
    const TYPE = 'pdf';
    const NAME = 'Agreement';
    const SIGNER_ID = 'FirstSignerId';
    const SIGNER_NAME = 'Kraft';
    const SIGNER_SURNAME = 'Lawrence';
    const SIGNER_CODE = '51001091072';
    const SIGNER_PHONE = '+37060000007';
    const FILE_TOKEN = 'UploadedFileToken';
    const POSTBACK_URL = 'https://www.example.org/postback.php';
    const LANGUAGE = 'lt';
    const PDF_LEVEL = 1;

    /** @var Create */
    private $query;

    /** @var Create */
    private $queryMinimal;

    public function setUp()
    {
        $this->query = new Create(
            self::TYPE,
            self::NAME,
            [
                [
                    'token' => self::FILE_TOKEN,
                ],
            ],
            [
                [
                    'id' => self::SIGNER_ID,
                    'name' => self::SIGNER_NAME,
                    'surname' => self::SIGNER_SURNAME,
                    'code' => self::SIGNER_CODE,
                    'phone' => self::SIGNER_PHONE,
                ],
            ],
            self::POSTBACK_URL,
            self::LANGUAGE,
            [
                'level' => self::PDF_LEVEL,
            ]
        );

        $this->queryMinimal = new Create(
            self::TYPE,
            self::NAME,
            [
                [
                    'token' => self::FILE_TOKEN,
                ],
            ]
        );
    }

    public function testGetFields()
    {
        $fields = $this->query->getFields();

        $this->assertArrayHasKey('type', $fields);
        $this->assertArrayHasKey('name', $fields);
        $this->assertArrayHasKey('files', $fields);
        $this->assertArrayHasKey('signers', $fields);
        $this->assertArrayHasKey('postback_url', $fields);
        $this->assertArrayHasKey('language', $fields);
        $this->assertArrayHasKey(self::TYPE, $fields);

        $this->assertSame(self::TYPE, $fields['type']);
        $this->assertSame(self::NAME, $fields['name']);
        $this->assertSame(self::POSTBACK_URL, $fields['postback_url']);
        $this->assertSame(self::LANGUAGE, $fields['language']);


        $this->assertArrayHasKey(0, $fields['files']);
        $this->assertArrayHasKey('token', $fields['files'][0]);

        $this->assertSame(self::FILE_TOKEN, $fields['files'][0]['token']);


        $this->assertArrayHasKey(0, $fields['signers']);
        $this->assertArrayHasKey('id', $fields['signers'][0]);
        $this->assertArrayHasKey('name', $fields['signers'][0]);
        $this->assertArrayHasKey('surname', $fields['signers'][0]);
        $this->assertArrayHasKey('code', $fields['signers'][0]);
        $this->assertArrayHasKey('phone', $fields['signers'][0]);

        $this->assertSame(self::SIGNER_ID, $fields['signers'][0]['id']);
        $this->assertSame(self::SIGNER_NAME, $fields['signers'][0]['name']);
        $this->assertSame(self::SIGNER_SURNAME, $fields['signers'][0]['surname']);
        $this->assertSame(self::SIGNER_CODE, $fields['signers'][0]['code']);
        $this->assertSame(self::SIGNER_PHONE, $fields['signers'][0]['phone']);


        $this->assertArrayHasKey('level', $fields[self::TYPE]);

        $this->assertSame(self::PDF_LEVEL, $fields[self::TYPE]['level']);
    }

    public function testGetFieldsMinimal()
    {
        $fields = $this->queryMinimal->getFields();

        $this->assertArrayHasKey('type', $fields);
        $this->assertArrayHasKey('name', $fields);
        $this->assertArrayHasKey('files', $fields);
        $this->assertArrayNotHasKey('signers', $fields);

        $this->assertSame(self::TYPE, $fields['type']);
        $this->assertSame(self::NAME, $fields['name']);


        $this->assertArrayHasKey(0, $fields['files']);
        $this->assertArrayHasKey('token', $fields['files'][0]);

        $this->assertSame(self::FILE_TOKEN, $fields['files'][0]['token']);
    }

    public function testGetAction()
    {
        $this->assertSame('signing/create', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->query->getMethod());
    }

    public function testCreateResult()
    {
        $this->assertInstanceOf('Isign\Gateway\Result\Signing\CreateResult', $this->query->createResult());
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
