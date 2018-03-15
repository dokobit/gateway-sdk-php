<?php
namespace Isign\Gateway\Tests\Query\Signing;

use Isign\Gateway\Query\Signing\Delete;
use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Tests\TestCase;

class DeleteTest extends TestCase
{
    const TOKEN = 'UploadedFileToken';

    /** @var Delete */
    private $query;

    public function setUp()
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
        $this->assertInstanceOf('Isign\Gateway\Result\Signing\DeleteResult', $this->query->createResult());
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
