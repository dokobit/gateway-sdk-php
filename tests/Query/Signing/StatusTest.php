<?php
namespace Dokobit\Gateway\Tests\Query\Signing;

use Dokobit\Gateway\Query\Signing\Status;
use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Tests\TestCase;

class StatusTest extends TestCase
{
    const TOKEN = 'SigningToken';

    /** @var Status */
    private $query;

    public function setUp()
    {
        $this->query = new Status(
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
        $this->assertSame('signing/'.self::TOKEN.'/status', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::GET, $this->query->getMethod());
    }

    public function testCreateResult()
    {
        $this->assertInstanceOf('Dokobit\Gateway\Result\Signing\StatusResult', $this->query->createResult());
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
