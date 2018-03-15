<?php
namespace Isign\Gateway\Tests\Integration\Signing;

use Isign\Gateway\Query\Signing\Prepare;
use Isign\Gateway\Query\Signing\Sign;
use Isign\Gateway\Result\Signing\PrepareResult;
use Isign\Gateway\Result\Signing\SignResult;
use Isign\Gateway\Tests\Integration\TestCase;

class PrepareTest extends TestCase
{
    public function testPrepare()
    {
        $this->createSigning();

        /** @var PrepareResult $result */
        $result = $this->client->get(new Prepare(
            $this->signingToken,
            self::SIGNER1_ID,
            base64_encode(CERTIFICATE_SIGN)
        ));

        $this->assertSame('ok', $result->getStatus());
        $this->assertSame('sha256', $result->getAlgorithm());
        $this->assertNotEmpty($result->getDtbs());
        $this->assertNotEmpty($result->getDtbsHash());

        return [
            'dtbs' => $result->getDtbs(),
            'signingToken' => $this->signingToken,
        ];
    }

    /**
     * @depends testPrepare
     */
    public function testSign(array $data)
    {
        /** @var SignResult $result */
        $result = $this->client->get(new Sign(
            $data['signingToken'],
            self::SIGNER1_ID,
            $this->sign($data['dtbs'], PRIVATE_KEY_SIGN)
        ));

        $this->assertSame('ok', $result->getStatus());
    }
}
