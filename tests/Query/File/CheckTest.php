<?php
namespace Dokobit\Gateway\Tests\Query\File;

use Dokobit\Gateway\Query\File\Check;
use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Tests\TestCase;

class CheckTest extends TestCase
{
    const TYPE = 'pdf';
    const NAME = 'document.pdf';

    /** @var Check */
    private $query;

    protected function setUp(): void
    {
        $this->query = new Check(
            self::TYPE,
            __DIR__.'/../../data/document.pdf'
        );
    }

    public function testGetFields()
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

    public function testGetFileFieldsWithNonExistingFile()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('File "" does not exist');
        $method = new Check(self::TYPE, '');
        $method->getFields();
    }

    public function testGetAction()
    {
        $this->assertSame('file/check', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->query->getMethod());
    }

    public function testCreateResult()
    {
        $this->assertInstanceOf('Dokobit\Gateway\Result\File\CheckResult', $this->query->createResult());
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
