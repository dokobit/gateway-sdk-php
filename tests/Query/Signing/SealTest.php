<?php
namespace Isign\Gateway\Tests\Query\Signing;

use Isign\Gateway\Query\Signing\Seal;
use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Tests\TestCase;

class SealTest extends TestCase
{
    const TOKEN = 'SigningToken';
    const SIGNING_NAME = 'E-Seal';
    const SIGNING_PURPOSE = 'signature';
    const PDF_PAGE = 1;
    const PDF_TOP = 456;
    const PDF_LEFT = 123;
    const PDF_WIDTH = 120;
    const PDF_HEIGHT = 50;


    /** @var Seal */
    private $queryMinimal;

    /** @var Seal */
    private $queryFull;

    public function setUp()
    {
        $this->queryMinimal = new Seal(
            self::TOKEN,
            self::SIGNING_NAME
        );

        $this->queryFull = new Seal(
            self::TOKEN,
            self::SIGNING_NAME,
            self::SIGNING_PURPOSE,
            [
                'annotation' => [
                    'page' => self::PDF_PAGE,
                    'top' => self::PDF_TOP,
                    'left' => self::PDF_LEFT,
                    'width' => self::PDF_WIDTH,
                    'height' => self::PDF_HEIGHT,
                ],
            ]
        );
    }

    public function testGetFieldsMinimal()
    {
        $fields = $this->queryMinimal->getFields();

        $this->assertArrayHasKey('token', $fields);
        $this->assertArrayHasKey('name', $fields);

        $this->assertSame(self::TOKEN, $fields['token']);
        $this->assertSame(self::SIGNING_NAME, $fields['name']);
    }

    public function testGetFieldsFull()
    {
        $fields = $this->queryFull->getFields();

        $this->assertArrayHasKey('token', $fields);
        $this->assertArrayHasKey('name', $fields);
        $this->assertArrayHasKey('signing_purpose', $fields);
        $this->assertArrayHasKey('pdf', $fields);
        $this->assertArrayHasKey('annotation', $fields['pdf']);
        $this->assertArrayHasKey('page', $fields['pdf']['annotation']);
        $this->assertArrayHasKey('top', $fields['pdf']['annotation']);
        $this->assertArrayHasKey('left', $fields['pdf']['annotation']);
        $this->assertArrayHasKey('width', $fields['pdf']['annotation']);
        $this->assertArrayHasKey('height', $fields['pdf']['annotation']);

        $this->assertSame(self::TOKEN, $fields['token']);
        $this->assertSame(self::SIGNING_NAME, $fields['name']);
        $this->assertSame(self::SIGNING_PURPOSE, $fields['signing_purpose']);
        $this->assertSame(self::PDF_PAGE, $fields['pdf']['annotation']['page']);
        $this->assertSame(self::PDF_TOP, $fields['pdf']['annotation']['top']);
        $this->assertSame(self::PDF_LEFT, $fields['pdf']['annotation']['left']);
        $this->assertSame(self::PDF_WIDTH, $fields['pdf']['annotation']['width']);
        $this->assertSame(self::PDF_HEIGHT, $fields['pdf']['annotation']['height']);
    }

    public function testGetAction()
    {
        $this->assertSame('signing/'.self::TOKEN.'/seal', $this->queryMinimal->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::POST, $this->queryMinimal->getMethod());
    }

    public function testCreateResult()
    {
        $this->assertInstanceOf('Isign\Gateway\Result\Signing\SealResult', $this->queryMinimal->createResult());
    }

    public function testHasValidationConstraints()
    {
        $collection = $this->queryMinimal->getValidationConstraints();

        $this->assertInstanceOf(
            'Symfony\Component\Validator\Constraints\Collection',
            $collection
        );
    }
}
