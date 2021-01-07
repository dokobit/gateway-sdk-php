<?php
namespace Dokobit\Gateway\Tests\Query\Signing;

use Dokobit\Gateway\Query\Signing\Archive;
use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Tests\TestCase;

class ArchiveTest extends TestCase
{
    const TOKEN = 'UploadedFileToken';
    const POSTBACK_URL = 'https://www.example.org/postback.php';

    /** @var Archive */
    private $query;

    /** @var Archive */
    private $queryToken;

    public function setUp(): void
    {
        $this->query = new Archive(
            self::TOKEN,
            self::POSTBACK_URL
        );

        $this->queryNoPostback = new Archive(
            self::TOKEN
        );
    }

    public function testGetFields()
    {
        $fields = $this->query->getFields();

        $this->assertArrayHasKey('token', $fields);
        $this->assertArrayHasKey('postback_url', $fields);

        $this->assertSame(self::TOKEN, $fields['token']);
        $this->assertSame(self::POSTBACK_URL, $fields['postback_url']);
    }

    public function testGetFieldsNoPostback()
    {
        $fields = $this->queryNoPostback->getFields();

        $this->assertArrayHasKey('token', $fields);
        $this->assertArrayNotHasKey('postback_url', $fields);

        $this->assertSame(self::TOKEN, $fields['token']);
    }

    public function testGetAction()
    {
        $this->assertSame('signing/'.self::TOKEN.'/archive', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->query->getMethod());
    }

    public function testCreateResult()
    {
        $this->assertInstanceOf('Dokobit\Gateway\Result\Signing\ArchiveResult', $this->query->createResult());
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
