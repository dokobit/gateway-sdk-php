<?php
namespace Dokobit\Gateway\Query\File;

use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Result\File\UploadResult;
use Dokobit\Gateway\Result\ResultInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Upload a file to Gateway from URL.
 * @see https://gateway-sandbox.dokobit.com/api/doc#_api_file_upload
 */
class UploadFromUrl implements QueryInterface
{
    /** @var string url of the file to be uploded */
    private $url;

    /** @var string SHA256 digest of the file to be uploded */
    private $digest;

    /** @var string|null file name which will be sent to Gateway */
    private $filename;

    /**
     * @param string $url url of the file to be uploded
     * @param string $digest SHA256 digest of the file to be uploded
     * @param string|null $filename file name which will be sent to Gateway.
     *                    If null or not set, original file name will be sent.
     */
    public function __construct(string $url, string $digest, ?string $filename = null)
    {
        $this->url = $url;
        $this->digest = $digest;
        $this->filename = $filename;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        if ($this->filename === null) {
            $this->filename = basename(parse_url($this->url, PHP_URL_PATH));
        }

        $return = [
            'file' => [
                'name' => $this->filename,
                'digest' => $this->digest,
                'url' => $this->url,
            ],
        ];

        return $return;
    }

    /**
     * Validation constraints for request data validation
     * @return Assert\Collection
     */
    public function getValidationConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'file' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\Collection([
                    'name' => new Assert\Required([
                        new Assert\NotBlank(),
                    ]),
                    'url' => new Assert\Required([
                        new Assert\NotBlank(),
                        new Assert\Url(),
                    ]),
                    'digest' => new Assert\Required([
                        new Assert\NotBlank(),
                    ]),
                ]),
            ]),
        ]);
    }

    /**
     * Result object for this query result
     * @return UploadResult
     */
    public function createResult(): ResultInterface
    {
        return new UploadResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return 'file/upload';
    }

    /**
     * HTTP method to use
     * @return string
     */
    public function getMethod(): string
    {
        return QueryInterface::POST;
    }
}
