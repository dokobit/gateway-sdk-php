<?php
namespace Isign\Gateway\Tests\Query\File;

use Isign\Gateway\Query\File\Delete;
use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Tests\TestCase;

class DeleteTest extends TestCase
{
    const TOKEN = 'UploadedFileToken';

    /** @var Delete */
    private $query;

    /** @var Delete */
    private $queryToken;

    public function setUp()
    {
        $this->query = new Delete(
            self::TOKEN
        );
    }

    public function testGetFieldsPath()
    {
        $fields = $this->query->getFields();

        $this->assertArrayHasKey('token', $fields);

        $this->assertSame(self::TOKEN, $fields['token']);
    }

    public function testGetAction()
    {
        $this->assertSame('file/'.self::TOKEN.'/delete', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->query->getMethod());
    }

    public function testCreateResult()
    {
        $this->assertInstanceOf('Isign\Gateway\Result\File\DeleteResult', $this->query->createResult());
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
