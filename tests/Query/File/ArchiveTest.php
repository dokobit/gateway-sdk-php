<?php
namespace Dokobit\Gateway\Tests\Query\File;

use Dokobit\Gateway\Query\File\Archive;
use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Tests\TestCase;

class ArchiveTest extends TestCase
{
    const TYPE = 'pdf';
    const NAME = 'document.pdf';
    const TOKEN = 'UploadedFileToken';

    /** @var Archive */
    private $query;

    /** @var Archive */
    private $queryToken;

    public function setUp()
    {
        $this->query = new Archive(
            self::TYPE,
            __DIR__ . '/../../data/document.pdf'
        );

        $this->queryToken = new Archive(
            self::TYPE,
            self::TOKEN,
            true
        );
    }

    public function testGetFieldsPath()
    {
        $fields = $this->query->getFields();

        $this->assertArrayHasKey('type', $fields);
        $this->assertArrayHasKey('file', $fields);
        $this->assertArrayHasKey('name', $fields['file']);
        $this->assertArrayHasKey('digest', $fields['file']);
        $this->assertArrayHasKey('content', $fields['file']);

        $this->assertSame(self::TYPE, $fields['type']);
        $this->assertSame(self::NAME, $fields['file']['name']);
    }

    public function testGetFieldsToken()
    {
        $fields = $this->queryToken->getFields();

        $this->assertArrayHasKey('type', $fields);
        $this->assertArrayHasKey('file', $fields);
        $this->assertArrayHasKey('token', $fields['file']);

        $this->assertSame(self::TYPE, $fields['type']);
        $this->assertSame(self::TOKEN, $fields['file']['token']);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage File "" does not exist
     */
    public function testGetFileFieldsWithNonExistingFile()
    {
        $method = new Archive(self::TYPE, '');
        $method->getFields();
    }

    public function testGetAction()
    {
        $this->assertSame('archive', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->query->getMethod());
    }

    public function testCreateResult()
    {
        $this->assertInstanceOf('Dokobit\Gateway\Result\File\ArchiveResult', $this->query->createResult());
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
