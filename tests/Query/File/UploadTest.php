<?php
namespace Isign\Gateway\Tests\Query\File;

use Isign\Gateway\Query\File\Upload;
use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Tests\TestCase;

class UploadTest extends TestCase
{
    const NAME = 'document.pdf';
    const NAME_OVERRIDE = 'custom filename.pdf';

    /** @var Upload */
    private $query;

    /** @var Upload */
    private $queryOverriddenFilename;

    public function setUp()
    {
        $this->query = new Upload(
            __DIR__ . '/../../data/document.pdf'
        );

        $this->queryOverriddenFilename = new Upload(
            __DIR__ . '/../../data/document.pdf',
            self::NAME_OVERRIDE
        );
    }

    public function testGetFields()
    {
        $fields = $this->query->getFields();

        $this->assertArrayHasKey('file', $fields);
        $this->assertArrayHasKey('name', $fields['file']);
        $this->assertArrayHasKey('digest', $fields['file']);
        $this->assertArrayHasKey('content', $fields['file']);

        $this->assertSame(self::NAME, $fields['file']['name']);
    }

    public function testGetFieldsWithOverriddenFilename()
    {
        $fields = $this->queryOverriddenFilename->getFields();

        $this->assertArrayHasKey('file', $fields);
        $this->assertArrayHasKey('name', $fields['file']);
        $this->assertArrayHasKey('digest', $fields['file']);
        $this->assertArrayHasKey('content', $fields['file']);

        $this->assertSame(self::NAME_OVERRIDE, $fields['file']['name']);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage File "" does not exist
     */
    public function testGetFileFieldsWithNonExistingFile()
    {
        $method = new Upload('');
        $method->getFields();
    }

    public function testGetAction()
    {
        $this->assertSame('file/upload', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->query->getMethod());
    }

    public function testCreateResult()
    {
        $this->assertInstanceOf('Isign\Gateway\Result\File\UploadResult', $this->query->createResult());
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
