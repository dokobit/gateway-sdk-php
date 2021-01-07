<?php
namespace Dokobit\Gateway\Tests\Query\Signing;

use Dokobit\Gateway\Query\Signing\CreateBatch;
use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Tests\TestCase;

class CreateBatchTest extends TestCase
{
    const SIGNING_TOKEN_1 = 'signing1';
    const SIGNING_TOKEN_2 = 'signing2';
    const SIGNER_TOKEN_1 = 'signer1';
    const SIGNER_TOKEN_2 = 'signer2';

    /** @var CreateBatch */
    private $query;

    /** @var CreateBatch */
    private $queryMinimal;

    public function setUp(): void
    {
        $this->query = new CreateBatch(
            [
                ['token' => self::SIGNING_TOKEN_1, 'signer_token' => self::SIGNER_TOKEN_1],
                ['token' => self::SIGNING_TOKEN_2, 'signer_token' => self::SIGNER_TOKEN_2],
            ]
        );
    }

    public function testGetFields()
    {
        $fields = $this->query->getFields();

        $this->assertArrayHasKey('signings', $fields);
        $this->assertArrayHasKey(0, $fields['signings']);
        $this->assertArrayHasKey(1, $fields['signings']);
        $this->assertArrayHasKey('token', $fields['signings'][0]);
        $this->assertArrayHasKey('signer_token', $fields['signings'][0]);
        $this->assertArrayHasKey('token', $fields['signings'][1]);
        $this->assertArrayHasKey('signer_token', $fields['signings'][1]);

        $this->assertSame(self::SIGNING_TOKEN_1, $fields['signings'][0]['token']);
        $this->assertSame(self::SIGNER_TOKEN_1, $fields['signings'][0]['signer_token']);
        $this->assertSame(self::SIGNING_TOKEN_2, $fields['signings'][1]['token']);
        $this->assertSame(self::SIGNER_TOKEN_2, $fields['signings'][1]['signer_token']);
    }

    public function testGetAction()
    {
        $this->assertSame('signing/createbatch', $this->query->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->query->getMethod());
    }

    public function testCreateBatchResult()
    {
        $this->assertInstanceOf('Dokobit\Gateway\Result\Signing\CreateBatchResult', $this->query->createResult());
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
