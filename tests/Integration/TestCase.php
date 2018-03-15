<?php
namespace Isign\Gateway\Tests\Integration;

use Isign\Gateway\Client;
use Isign\Gateway\Query\File\Upload;
use Isign\Gateway\Query\Signing\Create;
use Isign\Gateway\Result\File\UploadResult;
use Isign\Gateway\Result\Signing\CreateResult;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Base test case
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    const SIGNER1_ID = 'Signer1';
    const SIGNER2_ID = 'Signer2';

    /** @var Client */
    protected $client;

    /** @var string */
    protected $fileToken;

    /** @var string */
    protected $signingToken;

    /** @var string */
    protected $signerToken;

    public function setUp()
    {
        $params = [
            'apiKey' => SANDBOX_API_KEY,
            'sandbox' => true,
        ];

        if (defined('SANDBOX_URL')) {
            $params['sandboxUrl'] = SANDBOX_URL;
        }

        $log = false;
        // Uncomment to enable request/response debugging
        // $log = null;

        $this->client = Client::create($params, $log);
    }

    /**
     * Upload an unsigned document file and set $this->fileToken to its token
     */
    protected function uploadFile()
    {
        /** @var UploadResult $result */
        $result = $this->client->get(new Upload(
            __DIR__ . '/../data/document.pdf'
        ));

        if ('ok' !== $result->getStatus() || empty($result->getToken())) {
            throw new \RuntimeException('Failed to upload file.');
        }

        $this->fileToken = $result->getToken();
    }

    /**
     * Create a signing and set $this->signingToken to its token
     */
    protected function createSigning()
    {
        if (empty($this->fileToken)) {
            $this->uploadFile();
        }

        /** @var CreateResult $result */
        $result = $this->client->get(new Create(
            'pdf',
            'Test signing',
            [
                [
                    'token' => $this->fileToken,
                ],
            ],
            [
                [
                    'id' => self::SIGNER1_ID,
                    'name' => 'Kraft',
                    'surname' => 'Lawrence',
                    'signing_purpose' => 'signature',
                ],
            ]
        ));

        if ('ok' !== $result->getStatus() || empty($result->getToken())) {
            throw new \RuntimeException('Failed to create signing.');
        }

        $this->signingToken = $result->getToken();
        $this->signerToken = $result->getSigners()[self::SIGNER1_ID];
    }

    protected function sign($dtbs, $key)
    {
        openssl_sign(base64_decode($dtbs), $signatureValue, $key, OPENSSL_ALGO_SHA256);

        return base64_encode($signatureValue);
    }
}
