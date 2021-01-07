<?php
namespace Dokobit\Gateway\Tests\Query\Signing;

use Dokobit\Gateway\Query\Signing\Delete;
use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Tests\TestCase;

class DeleteTest extends TestCase
{
    const TOKEN = 'UploadedFileToken';

    /** @var Delete */
    private $query;

    protected function setUp(): void
    {
        $this->query = new Delete(
            self::TOKEN
        );
    }

    public function testGetFields()
    {
        $fields = $this->query->getFields();

        $this->assertArrayHasKey('token', $fields);

        $this->assertSame(self::TOKEN, $fields['token']);
    }

    public function testGetAction()
    {
        $this->assertSame('signing/'.self::TOKEN.'/delete', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->query->getMethod());
    }

    public function testDeleteResult()
    {
        $this->assertInstanceOf('Dokobit\Gateway\Result\Signing\DeleteResult', $this->query->createResult());
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
